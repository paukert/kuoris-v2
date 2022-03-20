<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;

class DisciplineService
{
    private DisciplineRepository $disciplineRepository;

    public function __construct(DisciplineRepository $disciplineRepository)
    {
        $this->disciplineRepository = $disciplineRepository;
    }

    public function findOrCreate(string $abbr, string $name): Discipline
    {
        $discipline = $this->disciplineRepository->findOneBy(['abbr' => $abbr, 'name' => $name]);

        if (!$discipline) {
            $discipline = new Discipline();
            $discipline->setAbbr($abbr)->setName($name);
        }

        return $discipline;
    }
}
