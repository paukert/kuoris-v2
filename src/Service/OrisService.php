<?php

namespace App\Service;

use App\Client\OrisClient;
use App\Entity\Event;
use App\Mapper\OrisMapper;

class OrisService
{
    private OrisClient $orisClient;
    private OrisMapper $orisMapper;

    public function __construct(OrisClient $orisClient, OrisMapper $orisMapper)
    {
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
}
