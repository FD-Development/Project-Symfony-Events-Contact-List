<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Contact entity.
 */
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    /**
     * @var int id
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * @var string name
     */
    #[ORM\Column(type: 'string', length: 155)]
    #[Assert\Length(max: 155)]
    private string $name;

    /**
     * @var string|null surname
     */
    #[ORM\Column(type: 'string', length: 155, nullable: true)]
    #[Assert\Length(max: 155)]
    private ?string $surname;

    /**
     * @var string|null email
     */
    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 45)]
    private ?string $email;

    /**
     * @var string|null telephone number
     */
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 20)]
    private ?string $telephone;

    /**
     * @var DateTime|null birthdate
     */
    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type('datetime')]
    private ?DateTime $birthdate;

    /**
     * @var string|null notes
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 675)]
    private ?string $note;

    /**
     * @var Category|null Associated Category
     */
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Category::class)]
    #[Assert\NotBlank]
    private ?Category $category;

    /**
     * @var User Associated User
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private User $author;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
