<?php

namespace App\Mapper;

use App\Entity\Category;
use App\Entity\Race;
use App\Service\DisciplineService;
use App\Service\LevelService;
use App\Service\OrganizerService;
use DateTime;

class OrisMapper
{
    private DisciplineService $disciplineService;
    private LevelService $levelService;
    private OrganizerService $organizerService;

    private const ORGANIZERS_COUNT = 2;

    public function __construct(DisciplineService $disciplineService, LevelService $levelService, OrganizerService $orgazerService)
    {
        $this->disciplineService = $disciplineService;
        $this->levelService = $levelService;
        $this->organizerService = $orgazerService;
    }

    public function createRace(array $eventData): Race
    {
        $categories = [];
        if (isset($eventData['Data']['Classes'])) {
            foreach ($eventData['Data']['Classes'] as $class) {
                if (isset($class['Name']) && isset($class['ID'])) {
                    $category = new Category();
                    $category->setName($class['Name'])->setOrisID($class['ID']);
                    $categories[] = $category;
                }
            }
        }

        $discipline = isset($eventData['Data']['Discipline']['ShortName']) && isset($eventData['Data']['Discipline']['NameCZ']) ?
            $this->disciplineService->findOrCreate($eventData['Data']['Discipline']['ShortName'], $eventData['Data']['Discipline']['NameCZ']) : null;
        $level = isset($eventData['Data']['Level']['ShortName']) && isset($eventData['Data']['Level']['NameCZ']) ?
            $this->levelService->findOrCreate($eventData['Data']['Level']['ShortName'], $eventData['Data']['Level']['NameCZ']) : null;

        $organizers = [];
        for ($i = 1; $i < self::ORGANIZERS_COUNT + 1; $i++) {
            if (isset($eventData['Data']['Org' . $i]['Name'])) {
                $organizers[] = $this->organizerService->findOrCreate($eventData['Data']['Org' . $i]['Name']);
            }
        }

        $raceStart = isset($eventData['Data']['Date']) && isset($eventData['Data']['StartTime']) ?
            new DateTime($eventData['Data']['Date'] . ' ' . $eventData['Data']['StartTime']) : new DateTime('now');

        $race = new Race();
        $race->setAutoUpdate(true)
            ->setDate($raceStart)
            ->setDescription(null)
            ->setDiscipline($discipline)
            ->setEntryDeadline(new DateTime($eventData['Data']['EntryDate1'] ?? 'now'))
            ->setIsCancelled(false)
            ->setLevel($level)
            ->setLocation($eventData['Data']['Place'] ?? 'Neznámé místo')
            ->setName($eventData['Data']['Name'] ?? 'Neznámý název')
            ->setOrisId($eventData['Data']['ID'] ?? 'Neznámé ORIS ID')
            ->setWebsite(null);

        foreach ($organizers as $organizer) {
            $race->addOrganizer($organizer);
        }

        foreach ($categories as $category) {
            $race->addCategory($category);
        }

        return $race;
    }
}
