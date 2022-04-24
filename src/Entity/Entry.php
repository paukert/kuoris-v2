<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EntryRepository::class)]
class Entry
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Type(type: Event::class)]
    private $event;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Type(type: Member::class)]
    private $member;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Type(type: Category::class)]
    private $category;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $car = false;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $wasSentToOris = false;

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

    public function getWasSentToOris(): ?bool
    {
        return $this->wasSentToOris;
    }

    public function setWasSentToOris(bool $wasSentToOris): self
    {
        $this->wasSentToOris = $wasSentToOris;

        return $this;
    }
}
