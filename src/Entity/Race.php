<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
class Race extends Event
{
    private const ORIS_EVENT_URL = 'https://oris.orientacnisporty.cz/Zavod?id=';

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Type(type: 'integer')]
    private $orisId;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $autoUpdate = true;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Assert\Url]
    private $website;

    #[ORM\ManyToOne(targetEntity: Level::class, cascade: ['persist'], inversedBy: 'races')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(type: Level::class)]
    private $level;

    public function __construct()
    {
        parent::__construct();
    }

    public function getOrisId(): ?int
    {
        return $this->orisId;
    }

    public function setOrisId(?int $orisId): self
    {
        $this->orisId = $orisId;

        return $this;
    }

    public function getAutoUpdate(): ?bool
    {
        return $this->autoUpdate;
    }

    public function setAutoUpdate(bool $autoUpdate): self
    {
        $this->autoUpdate = $autoUpdate;

        return $this;
    }

    public function getWebsite(): ?string
    {
        if (!$this->website && $this->orisId) {
            return self::ORIS_EVENT_URL . $this->orisId;
        }
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function isRace(): bool
    {
        return true;
    }
}
