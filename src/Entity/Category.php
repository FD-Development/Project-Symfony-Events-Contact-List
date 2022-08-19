<?php

namespace App\Entity;


use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category Entity
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\UniqueConstraint(name:'uq_categories_title', columns:['title'])]
#[UniqueEntity(fields: ['title'])]
class Category
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
    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Type('string')]
    #[Assert\Length(min:2, max:30)]
    private string $title;

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
}
