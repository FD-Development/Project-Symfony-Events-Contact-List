<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use DateTime;

/**
 * Event entity
 */
#[ORM\Table(name: 'event')]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    /**
     * @var int id
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * @var string title
     */
    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private string $title;

    /**
     * @var string|null description
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 675)]
    private ?string $description;


    /**
     * @var Category Associated Category
     */
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable:false)]
    #[Assert\Type(Category::class)]
    #[Assert\NotBlank]
    private Category $category;

    /**
     * @var Collection<Tag> Associated Tags
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable:false)]
    #[ORM\JoinTable(name: 'event_tags')]
    #[Assert\Valid]
    private Collection $tags;

    /**
     * @var User Associated User
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable:false)]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private User $author;

    /**
     * @var \DateTimeInterface Time at which the event starts
     */
    #[ORM\Column(type: 'time')]
    #[Assert\Type('DateTime')]
    private \DateTimeInterface $timeFrom;

    /**
     * @var \DateTimeInterface Date at which the event starts
     */
    #[ORM\Column(type: 'date')]
    #[Assert\Type('DateTime')]
    #[Assert\GreaterThanOrEqual(propertyPath:'dateFrom')]
    private \DateTimeInterface $dateFrom;

    /**
     * @var \DateTimeInterface Time at which the event ends
     */
    #[ORM\Column(type: 'time')]
    #[Assert\Type('DateTime')]
    private \DateTimeInterface $timeTo;

    /**
     * @var \DateTimeInterface Date at which the event ends
     */
    #[ORM\Column(type: 'date')]
    #[Assert\Type('DateTime')]
    private \DateTimeInterface $dateTo;

    /**
     * Form validation.
     * Prevents the user to create an event which ends before it starts
     *
     * @param ExecutionContextInterface $context
     *
     * @return void
     */
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context) :void
    {
        if ($this->getDateFrom() === $this->getDateTo() && $this->getTimeFrom() > $this->getTimeTo())
        {
            $context->buildViolation('message.form_event_time_violation')
                ->atPath('time_to')
                ->addViolation();
        }
        elseif ( $this->getDateFrom() > $this->getDateTo() ){
            $context->buildViolation('message.form_event_time_violation')
                ->atPath('date_to')
                ->addViolation();
        }
    }

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTimeFrom(): ?\DateTimeInterface
    {
        return $this->timeFrom;
    }

    public function setTimeFrom(\DateTimeInterface $timeFrom): self
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->timeTo;
    }

    public function setTimeTo(\DateTimeInterface $timeTo): self
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }
}
