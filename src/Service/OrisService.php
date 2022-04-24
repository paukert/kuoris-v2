<?php

namespace App\Service;

use App\Client\OrisClient;
use App\Entity\Event;
use App\Mapper\OrisMapper;

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

        if (!$eventData || $eventData['Status'] !== 'OK') {
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
}
