<?php
/**
 * Category Entity.
 */

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category Entity class.
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\UniqueConstraint(name: 'uq_categories_title', columns: ['title'])]
#[UniqueEntity(fields: ['title'])]
class Category
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
    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2, max: 30)]
    private string $title;

    /**
     * Gets Category id.
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
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
