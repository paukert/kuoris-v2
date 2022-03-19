<?php

namespace App\Service;

use App\Entity\Entry;
use App\Entity\Event;
use App\Entity\Member;
use App\Repository\EntryRepository;
use Doctrine\ORM\EntityManagerInterface;

class EntryService
{
    private EntityManagerInterface $entityManager;
    private EntryRepository $entryRepository;

    public function __construct(EntityManagerInterface $entityManager, EntryRepository $entryRepository)
    {
        $this->entityManager = $entityManager;
        $this->entryRepository = $entryRepository;
    }

    public function delete(Entry $entry): void
    {
        $this->entityManager->remove($entry);
        $this->entityManager->flush();
    }

    public function getByIds(Event $event, Member $member): ?Entry
    {
        return $this->entryRepository->find(['event' => $event, 'member' => $member]);
    }

    public function isManaged(Entry $entry): bool
    {
        return $this->entityManager->contains($entry);
    }

    public function save(Entry $entry): void
    {
        $this->entityManager->persist($entry);
        $this->entityManager->flush();
    }
}
