<?php


/**
 * Contact service.
 */

namespace App\Service;

use App\Service\ContactServiceInterface;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Contact;

/**
 * Class ContactService.
 */
class ContactService implements ContactServiceInterface
{
    /**
     * Contact repository.
     */
    private ContactRepository $contactRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param ContactRepository $contactRepository Contact repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(ContactRepository $contactRepository, PaginatorInterface $paginator)
    {
        $this->contactRepository = $contactRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contactRepository->queryAll(),
            $page,
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function save(Contact $contact): void
    {
        $this->contactRepository->save($contact);
    }

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