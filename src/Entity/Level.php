<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    #[Assert\Length(min: 3, max: 150)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $name;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Length(max: 10)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $abbr;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: Race::class)]
    #[Assert\Type(type: Collection::class)]
    private $races;

    public function __construct()
    {
        $this->races = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAbbr(): ?string
    {
        return $this->abbr;
    }

    public function setAbbr(string $abbr): self
    {
        $this->abbr = $abbr;

        return $this;
    }

    /**
     * @return Collection<int, Race>
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(Race $race): self
    {
        if (!$this->races->contains($race)) {
            $this->races[] = $race;
            $race->setLevel($this);
        }

        return $this;
    }

    public function removeRace(Race $race): self
    {
        if ($this->races->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getLevel() === $this) {
                $race->setLevel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        if ($this->getName() && $this->getAbbr()) {
            return $this->getName() . ' (' . $this->getAbbr() . ')';
        }
        return 'Neznámý typ závodu';
    }
}
