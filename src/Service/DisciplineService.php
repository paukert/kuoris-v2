<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DisciplineService
{
    private DisciplineRepository $disciplineRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(DisciplineRepository $disciplineRepository, EntityManagerInterface $entityManager)
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->entityManager = $entityManager;
    }

    public function findOrCreate(string $abbr, string $name): Discipline
    {
        $discipline = $this->disciplineRepository->findOneBy(['abbr' => $abbr, 'name' => $name]);

        if (!$discipline) {
            $discipline = new Discipline();
            $discipline->setAbbr($abbr)->setName($name);
            $this->entityManager->persist($discipline);
            $this->entityManager->flush();
        }

        return $discipline;
    }
}
