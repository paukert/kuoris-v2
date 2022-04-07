<?php

namespace App\Service;

use App\Entity\Level;
use App\Repository\LevelRepository;
use Doctrine\ORM\EntityManagerInterface;

class LevelService
{
    private EntityManagerInterface $entityManager;
    private LevelRepository $levelRepository;

    public function __construct(EntityManagerInterface $entityManager, LevelRepository $levelRepository)
    {
        $this->entityManager = $entityManager;
        $this->levelRepository = $levelRepository;
    }

    public function findOrCreate(string $abbr, string $name): Level
    {
        $level = $this->levelRepository->findOneBy(['abbr' => $abbr, 'name' => $name]);

        if (!$level) {
            $level = new Level();
            $level->setAbbr($abbr)->setName($name);
            $this->entityManager->persist($level);
            $this->entityManager->flush();
        }

        return $level;
    }
}
