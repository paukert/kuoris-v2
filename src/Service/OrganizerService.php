<?php

namespace App\Service;

use App\Entity\Organizer;
use App\Repository\OrganizerRepository;

class OrganizerService
{
    private OrganizerRepository $organizerRepository;

    public function __construct(OrganizerRepository $organizerRepository)
    {
        $this->organizerRepository = $organizerRepository;
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
}
