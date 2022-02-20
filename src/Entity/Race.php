<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
class Race extends Event
{
    #[ORM\Column(type: 'integer', nullable: true)]
    private $orisId;

    #[ORM\Column(type: 'boolean')]
    private $autoUpdate = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $website;

    #[ORM\ManyToMany(targetEntity: Competition::class, mappedBy: 'races')]
    private $competitions;

    public function __construct()
    {
        parent::__construct();
        $this->competitions = new ArrayCollection();
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
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection<int, Competition>
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
            $competition->addRace($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competitions->removeElement($competition)) {
            $competition->removeRace($this);
        }

        return $this;
    }
}
