<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tag entity class.
 */
#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    /**
     * Id.
     *
     * @var int Id
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * Title.
     *
     * @var string Title
     */
    #[ORM\Column(type: 'string', length: 65)]
    #[Assert\Length(min: 2, max: 65)]
    private string $title;

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
     * Converts to string.
     *
     * @return string string
     */
    public function __toString()
    {
        return $this->title;
    }
}
