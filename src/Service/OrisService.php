<?php

namespace App\Service;

use App\Client\OrisClient;
use App\Entity\Event;
use App\Entity\Race;
use App\Mapper\OrisMapper;
use DateTime;

class OrisService
{
    private const DELAY_BETWEEN_REQUESTS = 100000;

    private EntryService $entryService;
    private EventService $eventService;
    private OrisClient $orisClient;
    private OrisMapper $orisMapper;

    public function __construct(EntryService $entryService, EventService $eventService, OrisClient $orisClient, OrisMapper $orisMapper)
    {
        $this->entryService = $entryService;
        $this->eventService = $eventService;
        $this->orisClient = $orisClient;
        $this->orisMapper = $orisMapper;
    }

    public function getRace(int $orisId): ?Event
    {
        $eventData = $this->orisClient->getRaceData($orisId);

        if ($eventData === null) {
            return null;
        }

        return $this->orisMapper->createRace($eventData);
    }

    public function sendEntries(int $eventId, string $username, string $password): bool
    {
        $event = $this->eventService->getById($eventId);
        if ($event === null) {
            return false;
        }

        $params['username'] = $username;
        $params['password'] = $password;

        foreach ($event->getEntries() as $entry) {
            if ($entry->getWasSentToOris()) {
                continue;
            } elseif ($entry->getMember()->getClubUserOrisId() === null) {
                return false;
            }

            $params['clubuser'] = $entry->getMember()->getClubUserOrisId();
            $params['class'] = $entry->getCategory()->getOrisId();
            if (!$this->orisClient->sendEntry($params)) {
                return false;
            }

            $entry->setWasSentToOris(true);
            $this->entryService->save($entry);
            usleep(self::DELAY_BETWEEN_REQUESTS);
        }
        return true;
    }

    // TODO: send notification to administrators about changes
    public function checkAndFixDeadlines(): void
    {
        $remotestRace = $this->eventService->getRemotestRace();
        $orisRaces = $this->orisClient->getListOfEvents($remotestRace->getDate()->format('Y-m-d'));

        /** @var Race[] $races */
        $races = $this->eventService->getEventsWithNearestDeadline(Race::class, PHP_INT_MAX);

        foreach ($races as $race) {
            if ($race->getOrisId() === null || $race->getAutoUpdate() === false) {
                continue;
            }

            $eventName = 'Event_' . $race->getOrisId();
            $deadline = $orisRaces['Data'][$eventName]['EntryDate1'] ?? null;

            if ($deadline === null) {
                continue;
            }

            try {
                $kuorisDeadline = (new DateTime($deadline))->modify('- 1 day');
            } catch (\Exception) {
                $kuorisDeadline = null;
            }

            if ($kuorisDeadline !== null && $kuorisDeadline < $race->getEntryDeadline()) {
                $race->setEntryDeadline($kuorisDeadline);
                $this->eventService->save($race);
            }
        }
    }
}
