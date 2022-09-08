<?php
/**
 * Event Entity.
 */

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Event entity class.
 */
#[ORM\Table(name: 'event')]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    /**
     * Id.
     *
     * @var int id
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * Title.
     *
     * @var string title
     */
    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private string $title;

    /**
     * Description.
     *
     * @var string|null description
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 675)]
    private ?string $description;

    /**
     * Category.
     *
     * @var Category Associated Category
     */
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type(Category::class)]
    #[Assert\NotBlank]
    private Category $category;

    /**
     * Tags.
     *
     * @var Collection<int, Tag> Associated Tags
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\JoinTable(name: 'event_tags')]
    #[Assert\Valid]
    private Collection $tags;

    /**
     * Author.
     *
     * @var User Associated User
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private User $author;

    /**
     * Time from.
     *
     * @var \DateTimeInterface Time at which the event starts
     */
    #[ORM\Column(type: 'time')]
    #[Assert\Type('DateTime')]
    private \DateTimeInterface $timeFrom;

    /**
     * Date from.
     *
     * @var \DateTimeInterface Date at which the event starts
     */
    #[ORM\Column(type: 'date')]
    #[Assert\Type('DateTime')]
    #[Assert\GreaterThanOrEqual(propertyPath: 'dateFrom')]
    private \DateTimeInterface $dateFrom;

    /**
     * Time to.
     *
     * @var \DateTimeInterface Time at which the event ends
     */
    #[ORM\Column(type: 'time')]
    #[Assert\Type('DateTime')]
    private \DateTimeInterface $timeTo;

    /**
     * Date to.
     *
     * @var \DateTimeInterface Date at which the event ends
     */
    #[ORM\Column(type: 'date')]
    #[Assert\Type('DateTime')]
    private \DateTimeInterface $dateTo;

    /**
     * Form validation.
     *
     * Prevents the user to create an event which ends before it starts.
     *
     * @param $context ExecutionContextInterface
     */
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if ($this->getDateFrom() === $this->getDateTo() && $this->getTimeFrom() > $this->getTimeTo()) {
            $context->buildViolation('message.form_event_time_violation')
                ->atPath('time_to')
                ->addViolation();
        } elseif ($this->getDateFrom() > $this->getDateTo()) {
            $context->buildViolation('message.form_event_time_violation')
                ->atPath('date_to')
                ->addViolation();
        }
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Gets id.
     *
     * @return int|null id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets title.
     *
     * @return string|null title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets title.
     *
     * @param string $title title
     *
     * @return $this title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets description.
     *
     * @param string|null $description description
     *
     * @return $this description
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets category.
     *
     * @return Category|null category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Sets category.
     *
     * @param Category|null $category category
     *
     * @return $this category
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Gets tag.
     *
     * @return Collection<int, Tag> tags
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Sets tag.
     *
     * @param Tag $tag tag
     *
     * @return $this tag
     */
    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * Removes tag.
     *
     * @param Tag $tag tag
     *
     * @return $this tag
     */
    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * Gets author.
     *
     * @return User|UserInterface author
     */
    public function getAuthor(): User|UserInterface
    {
        return $this->author;
    }

    /**
     * Sets author.
     *
     * @param User $author author
     *
     * @return $this author
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Gets TimeFrom.
     *
     * @return \DateTimeInterface|null Time
     */
    public function getTimeFrom(): ?\DateTimeInterface
    {
        return $this->timeFrom;
    }

    /**
     * Sets TimeFrom.
     *
     * @param \DateTimeInterface $timeFrom Time
     *
     * @return $this Time
     */
    public function setTimeFrom(\DateTimeInterface $timeFrom): self
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    /**
     * Gets DateFrom.
     *
     * @return \DateTimeInterface|null Date
     */
    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * Sets DateFrom.
     *
     * @param \DateTimeInterface $dateFrom Date
     *
     * @return $this Date
     */
    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Gets TimeTo.
     *
     * @return \DateTimeInterface|null Time
     */
    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->timeTo;
    }

    /**
     * Sets TimeTo.
     *
     * @param \DateTimeInterface $timeTo Time
     *
     * @return $this Time
     */
    public function setTimeTo(\DateTimeInterface $timeTo): self
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    /**
     * Gets DateTo.
     *
     * @return \DateTimeInterface|null Date
     */
    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    /**
     * Sets DateTo.
     *
     * @param \DateTimeInterface $dateTo Date
     *
     * @return $this Date
     */
    public function setDateTo(\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }
}
