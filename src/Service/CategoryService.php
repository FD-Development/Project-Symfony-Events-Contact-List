<?php


/**
 * Category service.
 */

namespace App\Service;

use App\Service\CategoryServiceInterface;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Category;

/**
 * Class CategoryService.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    /**
     * Event repository.
     */
    protected EventRepository $eventRepository;

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
     * @param CategoryRepository $categoryRepository Category repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator, EventRepository $eventRepository, ContactRepository $contactRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->contactRepository = $contactRepository;
        $this->categoryRepository = $categoryRepository;
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
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function save(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }


    /**
     * Can Category be deleted?
     *
     * @param Category $category Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Category $category): bool
    {
        try {
            $resultEvents = $this->eventRepository->countByCategory($category);
            $resultContacts = $this->contactRepository->countByCategory($category);

            return !($resultEvents > 0 || $resultContacts > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }


}
