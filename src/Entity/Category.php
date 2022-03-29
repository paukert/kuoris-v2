<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(max: 50)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $name;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Type(type: 'integer')]
    private $orisId;

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

    public function getOrisId(): ?int
    {
        return $this->orisId;
    }

    public function setOrisId(?int $orisId): self
    {
        $this->orisId = $orisId;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
