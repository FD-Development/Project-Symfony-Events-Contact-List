<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $title = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type('DateTime')]
    private $durationFrom;

    #[ORM\Column(type: 'datetime')]
    #[Assert\Type('DateTime')]
    #[Assert\GreaterThanOrEqual(propertyPath:'durationFrom')]
    private $durationTo;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 675)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private $category;

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

    public function getDurationFrom(): ?\DateTimeInterface
    {
        return $this->durationFrom;
    }

    public function setDurationFrom(\DateTimeInterface $durationFrom): self
    {
        $this->durationFrom = $durationFrom;

        return $this;
    }

    public function getDurationTo(): ?\DateTimeInterface
    {
        return $this->durationTo;
    }

    public function setDurationTo(\DateTimeInterface $durationTo): self
    {
        $this->durationTo = $durationTo;

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
}
