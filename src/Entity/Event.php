<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
#[ORM\DiscriminatorMap(["race" => "Race", "training" => "Training"])]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Length(min: 3, max: 100)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $name;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\Type(type: DateTime::class)]
    private $date;

    #[ORM\Column(type: 'string', length: 150)]
    #[Assert\Length(min: 3, max: 150)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $location;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\Type(type: DateTime::class)]
    private $entryDeadline;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    #[Assert\Length(max: 1000)]
    #[Assert\Type(type: 'string')]
    private $description;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private $isCancelled = false;

    #[ORM\ManyToOne(targetEntity: Discipline::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Type(type: Discipline::class)]
    private $discipline;

    #[ORM\ManyToMany(targetEntity: Organizer::class, inversedBy: 'events')]
    #[Assert\Count(min: 1)]
    #[Assert\Type(type: 'array')]
    private $organizers;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Entry::class)]
    #[Assert\Type(type: 'array')]
    private $entries;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Comment::class)]
    #[Assert\Type(type: 'array')]
    private $comments;

    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[Assert\Type(type: 'array')]
    private $categories;

    public function __construct()
    {
        $this->organizers = new ArrayCollection();
        $this->entries = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getEntryDeadline(): ?\DateTimeInterface
    {
        return $this->entryDeadline;
    }

    public function setEntryDeadline(\DateTimeInterface $entryDeadline): self
    {
        $this->entryDeadline = $entryDeadline;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsCancelled(): ?bool
    {
        return $this->isCancelled;
    }

    public function setIsCancelled(bool $isCancelled): self
    {
        $this->isCancelled = $isCancelled;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * @return Collection<int, Organizer>
     */
    public function getOrganizers(): Collection
    {
        return $this->organizers;
    }

    public function addOrganizer(Organizer $organizer): self
    {
        if (!$this->organizers->contains($organizer)) {
            $this->organizers[] = $organizer;
        }

        return $this;
    }

    public function removeOrganizer(Organizer $organizer): self
    {
        $this->organizers->removeElement($organizer);

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
            $entry->setEvent($this);
        }

        return $this;
    }

    public function removeEntry(Entry $entry): self
    {
        if ($this->entries->removeElement($entry)) {
            // set the owning side to null (unless already changed)
            if ($entry->getEvent() === $this) {
                $entry->setEvent(null);
            }
        }

        return $this;
    }

    public function getEntriesCount(): int
    {
        return $this->entries->count();
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
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Entry[]
     */
    public function getEntriesWithDrivers(): array
    {
        return array_filter($this->getEntries()->toArray(), fn(Entry $entry) => $entry->getCar());
    }
}
