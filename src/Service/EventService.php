<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;

class EventService
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @return Event[]
     */
    public function getEventsWithNearestDeadline(?string $class = null, int $maxResults = 5): array
    {
        return $this->eventRepository->findEventsWithNearestDeadline($class, $maxResults);
    }
}
