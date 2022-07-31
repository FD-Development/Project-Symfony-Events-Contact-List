<?php


/**
 * Event service.
 */

namespace App\Service;

use App\Service\EventServiceInterface;
use App\Repository\EventRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Event;
 use App\Entity\User;
use Symfony\Component\Intl\Data\Util\RecursiveArrayAccess;
use DateTime;

/**
 * Class EventService.
 */
class EventService implements EventServiceInterface
{
    /**
     * Event repository.
     */
    private EventRepository $eventRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Tag service.
     */
    private TagServiceInterface $tagService;

    /**
     * Constructor.
     *
     * @param EventRepository $eventRepository Event repository
     * @param PaginatorInterface $paginator Paginator
     * @param CategoryServiceInterface $categoryService Category service interface
     * @param TagServiceInterface $tagService Tag service interface
     *
     * #
     */
    public function __construct(
        EventRepository $eventRepository,
        PaginatorInterface $paginator,
        CategoryServiceInterface $categoryService,
        TagServiceInterface $tagService
    ) {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    /**
     * Get paginated list for specified user.
     *
     * @param int $page Page number
     * @param User $author Author
     * @param array $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface
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
     * @param int $page Page number
     * @param User $author Author
     * @param DateTime $date Date to search by
     * @param array $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getEventsByDate(int $page, User $author, DateTime $date, array $filters = [] ): PaginationInterface
    {
        $date = date_format( $date, 'Y-m-d');
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
     * @param int $page Page number
     * @param User $author Author
     * @param DateTime $date Date to search by
     * @param array $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getUpcomingEvents(int $page, User $author, DateTime $date, array $filters = [] ): PaginationInterface
    {
        $date = date_format( $date, 'Y-m-d');
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->eventRepository->queryUpcoming($author , $date , $filters),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE,
            array(
                'pageParameterName' => 'upcoming_page',
                'sortFieldParameterName' => 'sort1',
        'sortDirectionParameterName' => 'direction1',
            )
        );
    }

    public function save(Event $event): void
    {
        $this->eventRepository->save($event);
    }

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
