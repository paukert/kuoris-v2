<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training extends Event
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private $maxCapacity;

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(?int $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }
}
