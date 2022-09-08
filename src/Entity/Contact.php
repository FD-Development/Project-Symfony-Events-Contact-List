<?php
/**
 * Contact entity.
 */

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Contact entity class.
 */
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
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
     * Name.
     *
     * @var string name
     */
    #[ORM\Column(type: 'string', length: 155)]
    #[Assert\Length(max: 155)]
    private string $name;

    /**
     * Surname.
     *
     * @var string|null surname
     */
    #[ORM\Column(type: 'string', length: 155, nullable: true)]
    #[Assert\Length(max: 155)]
    private ?string $surname;

    /**
     * Email.
     *
     * @var string|null email
     */
    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 45)]
    private ?string $email;

    /**
     * Telephone number.
     *
     * @var string|null telephone number
     */
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 20)]
    private ?string $telephone;

    /**
     * Birthdate.
     *
     * @var DateTime|null birthdate
     */
    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type('datetime')]
    private ?DateTime $birthdate;

    /**
     * Notes.
     *
     * @var string|null notes
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 675)]
    private ?string $note;

    /**
     * Category.
     *
     * @var Category|null Associated Category
     */
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Category::class)]
    #[Assert\NotBlank]
    private ?Category $category;

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
     * Gets Contact id.
     *
     * @return int|null id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets name.
     *
     * @return string|null name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name name
     *
     * @return $this name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets surname.
     *
     * @return string|null surname
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * Sets surname.
     *
     * @param string|null $surname surname
     *
     * @return $this surname
     */
    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Gets email.
     *
     * @return string|null email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * @param string $email email
     *
     * @return $this email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets telephone.
     *
     * @return string|null telephone
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * Sets telephone.
     *
     * @param string|null $telephone telephone
     *
     * @return $this telephone
     */
    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Gets birthdate.
     *
     * @return \DateTimeInterface|null birthdate
     */
    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    /**
     * Sets birthdate.
     *
     * @param DateTime|null $birthdate birthdate
     *
     * @return $this birthdate
     */
    public function setBirthdate(?DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Gets note.
     *
     * @return string|null note
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * Sets note.
     *
     * @param string|null $note note
     *
     * @return $this note
     */
    public function setNote(?string $note): self
    {
        $this->note = $note;

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
     * Gets author.
     *
     * @return User|null author
     */
    public function getAuthor(): ?User
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
}
