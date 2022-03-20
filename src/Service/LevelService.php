<?php

namespace App\Service;

use App\Entity\Level;
use App\Repository\LevelRepository;

class LevelService
{
    private LevelRepository $levelRepository;

    public function __construct(LevelRepository $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }

    public function findOrCreate(string $abbr, string $name): Level
    {
        $level = $this->levelRepository->findOneBy(['abbr' => $abbr, 'name' => $name]);

        if (!$level) {
            $level = new Level();
            $level->setAbbr($abbr)->setName($name);
        }

        return $level;
    }
}
