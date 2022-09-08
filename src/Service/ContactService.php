<?php

/**
 * Contact service.
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Contact;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ContactService.
 */
class ContactService implements ContactServiceInterface
{
    /**
     * Contact repository.
     *
     * @var ContactRepository ContactRepository
     */
    private ContactRepository $contactRepository;

    /**
     * Tag repository.
     *
     * @var TagRepository tagRepository
     */
    private TagRepository $tagRepository;
    /**
     * Paginator.
     *
     * @var PaginatorInterface PaginationInterface
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param ContactRepository  $contactRepository Contact repository
     * @param TagRepository      $tagRepository     Tag repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(ContactRepository $contactRepository, TagRepository $tagRepository, PaginatorInterface $paginator)
    {
        $this->contactRepository = $contactRepository;
        $this->tagRepository = $tagRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page Page number
     * @param User|UserInterface $user User entity
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, UserInterface|User $user): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contactRepository->queryAll($user),
            $page,
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Contact $contact Contact entity
     */
    public function save(Contact $contact): void
    {
        $this->contactRepository->save($contact);
    }

    /**
     * Delete entity.
     *
     * @param Contact $contact Contact entity
     */
    public function delete(Contact $contact): void
    {
        $this->contactRepository->delete($contact);
    }

    /**
     * Find by title.
     *
     * @param string $title Tag title
     *
     * @return Tag|null Tag entity
     */
    public function findOneByTitle(string $title): ?Tag
    {
        return $this->tagRepository->findOneByTitle($title);
    }
}
