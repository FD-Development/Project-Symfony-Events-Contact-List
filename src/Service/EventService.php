<?php

/**
 * Event service.
 */

namespace App\Service;

use App\Entity\Event;
use App\Entity\Tag;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\TagRepository;
use DateTime;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class EventService.
 */
class EventService implements EventServiceInterface
{
    /**
     * Event repository.
     *
     * @var EventRepository EventRepository
     */
    private EventRepository $eventRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface PaginationInterface
     */
    private PaginatorInterface $paginator;

    /**
     * Category service.
     *
     * @var CategoryServiceInterface CategoryServiceInterface
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Tag service.
     *
     * @var TagServiceInterface TagServiceInterface
     */
    private TagServiceInterface $tagService;

    /**
     * Tag repository.
     *
     * @var TagRepository Tag repostiory
     */
    private TagRepository $tagRepository;

    /**
     * Constructor.
     *
     * @param EventRepository          $eventRepository Event repository
     * @param PaginatorInterface       $paginator       Paginator
     * @param CategoryServiceInterface $categoryService Category service interface
     * @param TagServiceInterface      $tagService      Tag service interface
     * @param TagRepository            $tagRepository   tag repository
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator, CategoryServiceInterface $categoryService, TagServiceInterface $tagService, TagRepository $tagRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Get paginated list for specified user.
     *
     * @param int                $page    Page number
     * @param User|UserInterface $author  Author
     * @param array<string, int> $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User|UserInterface $author, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->eventRepository->queryByAuthor($author, $filters),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list of events that are in specified date.
     *
     * @param int                $page    Page number
     * @param User|UserInterface $author  Author
     * @param DateTime           $date    Date to search by
     * @param array<string, int> $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getEventsByDate(int $page, User|UserInterface $author, DateTime $date, array $filters = []): PaginationInterface
    {
        $date = date_format($date, 'Y-m-d');
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->eventRepository->queryByDate($author, $date, $filters),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list of events that start after specified date.
     *
     * @param int                $page    Page number
     * @param User|UserInterface $author  Author
     * @param DateTime           $date    Date to search by
     * @param array<string, int> $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getUpcomingEvents(int $page, User|UserInterface $author, DateTime $date, array $filters = []): PaginationInterface
    {
        $date = date_format($date, 'Y-m-d');
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->eventRepository->queryUpcoming($author, $date, $filters),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE,
            [
                'pageParameterName' => 'upcoming_page',
                'sortFieldParameterName' => 'sort1',
            'sortDirectionParameterName' => 'direction1',
            ]
        );
    }

    /**
     * Save entity.
     *
     * @param Event $event Event entity
     */
    public function save(Event $event): void
    {
        $this->eventRepository->save($event);
    }

    /**
     * Delete entity.
     *
     * @param Event $event Event entity
     */
    public function delete(Event $event): void
    {
        $this->eventRepository->delete($event);
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
     * Prepare filters for the event list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (!empty($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
