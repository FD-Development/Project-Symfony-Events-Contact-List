<?php


/**
 * Tag service.
 */

namespace App\Service;

use App\Service\TagServiceInterface;
use App\Repository\TagRepository;
use App\Repository\EventRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Tag;

/**
 * Class TagService.
 */
class TagService implements TagServiceInterface
{
    /**
     * Tag repository.
     */
    private TagRepository $tagRepository;

    /**
     * Event repository.
     */
    protected EventRepository $eventRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param TagRepository $tagRepository Tag repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(TagRepository $tagRepository, PaginatorInterface $paginator, EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->tagRepository = $tagRepository;
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
            $this->tagRepository->queryAll(),
            $page,
            TagRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function save(Tag $tag): void
    {
        $this->tagRepository->save($tag);
    }

    public function delete(Tag $tag): void
    {
        $this->tagRepository->delete($tag);
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

    /**
     * Find by id.
     *
     * @param int $id Tag id
     *
     * @return Tag|null Tag entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Tag
    {
        return $this->tagRepository->findOneById($id);
    }


}
