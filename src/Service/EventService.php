<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class EventService
{
    private EntityManagerInterface $entityManager;
    private EventRepository $eventRepository;

    public function __construct(EntityManagerInterface $entityManager, EventRepository $eventRepository)
    {
        $this->entityManager = $entityManager;
        $this->eventRepository = $eventRepository;
    }

    public function getById(int $eventId): ?Event
    {
        return $this->eventRepository->find($eventId);
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

    public function save(Event $event): void
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }
}
