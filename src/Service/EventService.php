<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\Query;

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

    public function getEventsQuery(?string $hint = null, bool $excludePastEvents = true, ?string $class = null): Query
    {
        return $this->eventRepository->findEventsQuery($hint, $excludePastEvents, $class);
    }
}
