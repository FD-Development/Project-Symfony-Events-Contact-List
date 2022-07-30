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
     * @param User $author Author
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->queryByAuthor($author),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }


    /**
     * Get events that are in current date.
     *
     * @param int $page Page number
     * @param User $author Author
     * @param DateTime $date Date to search by
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getEventsByDate(int $page, User $author, DateTime $date): PaginationInterface
    {
        $date = date_format( $date, 'Y-m-d');

        return $this->paginator->paginate(
            $this->eventRepository->queryByDate($author , $date),
            $page,
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
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


}
