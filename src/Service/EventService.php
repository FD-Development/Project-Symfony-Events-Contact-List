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
     * Constructor.
     *
     * @param EventRepository $eventRepository Event repository
     * @param PaginatorInterface $paginator Paginator
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->eventRepository = $eventRepository;
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
            $this->eventRepository->queryAll(),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function save(Event $event): void
    {

        $this->eventRepository->save($event);
    }


}
