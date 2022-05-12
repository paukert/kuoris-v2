<?php

namespace App\Service;

use App\Entity\Organizer;
use App\Repository\OrganizerRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrganizerService
{
    private OrganizerRepository $organizerRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, OrganizerRepository $organizerRepository)
    {
        $this->organizerRepository = $organizerRepository;
        $this->entityManager = $entityManager;
    }

    public function findOrCreate(string $name): Organizer
    {
        $organizer = $this->organizerRepository->findOneBy(['name' => $name]);

        if (!$organizer) {
            $organizer = new Organizer();
            $organizer->setName($name);
        }

        return $organizer;
    }

    /**
     * @return Organizer[]
     */
    public function getAll(): array
    {
        return $this->organizerRepository->findAll();
    }

    public function getOneBy(array $criteria, array $orderBy = null): ?Organizer
    {
        return $this->organizerRepository->findOneBy($criteria, $orderBy);
    }

    public function remove(Organizer $organizer): void
    {
        $this->entityManager->remove($organizer);
    }
}
