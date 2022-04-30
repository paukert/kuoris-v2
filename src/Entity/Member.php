<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[UniqueEntity('registration', message: 'Uživatel s uvedeným registračním číslem již existuje.')]
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_TRAINER = 'ROLE_TRAINER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10, unique: true)]
    #[Assert\Length(min: 5, max: 10)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $registration;

    #[ORM\Column(type: 'json')]
    #[Assert\Type(type: 'array')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Assert\Length(max: 255)]
    #[Assert\Type(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Length(min: 2, max: 100)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $firstName;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Length(min: 2, max: 100)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $lastName;

    #[ORM\Column(type: 'string', length: 200)]
    #[Assert\Email]
    #[Assert\Length(max: 200)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $mail;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $sendNotification = false;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Assert\Type(type: 'bool')]
    private $activeMembership;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Type(type: 'integer')]
    private $bankBalance;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Comment::class)]
    #[Assert\Type(type: Collection::class)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Announcement::class)]
    #[Assert\Type(type: Collection::class)]
    private $announcements;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Entry::class)]
    #[Assert\Type(type: Collection::class)]
    private $entries;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $isActive = false;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Type(type: 'integer')]
    private $clubUserOrisId;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->announcements = new ArrayCollection();
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->registration;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->registration;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getSendNotification(): ?bool
    {
        return $this->sendNotification;
    }

    public function setSendNotification(bool $sendNotification): self
    {
        $this->sendNotification = $sendNotification;

        return $this;
    }

    public function getActiveMembership(): ?bool
    {
        return $this->activeMembership;
    }

    public function setActiveMembership(?bool $activeMembership): self
    {
        $this->activeMembership = $activeMembership;

        return $this;
    }

    public function getBankBalance(): ?int
    {
        return $this->bankBalance;
    }

    public function setBankBalance(?int $bankBalance): self
    {
        $this->bankBalance = $bankBalance;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMember($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMember() === $this) {
                $comment->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): self
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements[] = $announcement;
            $announcement->setMember($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): self
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getMember() === $this) {
                $announcement->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Entry>
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(Entry $entry): self
    {
        if (!$this->entries->contains($entry)) {
            $this->entries[] = $entry;
            $entry->setMember($this);
        }

        return $this;
    }

    public function removeEntry(Entry $entry): self
    {
        if ($this->entries->removeElement($entry)) {
            // set the owning side to null (unless already changed)
            if ($entry->getMember() === $this) {
                $entry->setMember(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getName(): ?string
    {
        if ($this->getFirstName() && $this->getLastName()) {
            return $this->getFirstName() . ' ' . $this->getLastName();
        }
        return null;
    }

    public function getClubUserOrisId(): ?int
    {
        return $this->clubUserOrisId;
    }

    public function setClubUserOrisId(?int $clubUserOrisId): self
    {
        $this->clubUserOrisId = $clubUserOrisId;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?? 'Neznámé jméno člena';
    }
}
