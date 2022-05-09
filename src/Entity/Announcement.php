<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnnouncementRepository::class)]
class Announcement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Length(min: 5, max: 100)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $headline;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\Length(min: 5, max: 500)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $text;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\Type(type: DateTime::class)]
    private $publishedAt;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $isVisible = true;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'announcements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Type(type: Member::class)]
    private $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
        $this->publishedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): self
    {
        $this->headline = $headline;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getLabel(): string
    {
        return mb_strimwidth($this->getPublishedAt()->format('Y-m-d') . ' – ' . $this->getHeadline(), 0, 75, '...');
    }
}
