<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntryRepository::class)]
class Entry
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    private $event;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    private $member;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\Column(type: 'boolean')]
    private $car = false;

    public function __construct(Event $event, Member $member)
    {
        $this->event = $event;
        $this->member = $member;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCar(): ?bool
    {
        return $this->car;
    }

    public function setCar(bool $car): self
    {
        $this->car = $car;

        return $this;
    }
}
