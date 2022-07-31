<?php

/**
 * Event service interface.
 */

namespace App\Service;

use App\Entity\Event;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Intl\Data\Util\RecursiveArrayAccess;
use DateTime;

/**
 * Interface EventServiceInterface.
 */
interface EventServiceInterface
{
    /**
     * Get paginated list for specified user.
     *
     * @param int $page Page number
     * @param User $author Author
     * @param array $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface;

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
    public function getEventsByDate(int $page, User $author, DateTime $date, array $filters): PaginationInterface;

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
    public function getUpcomingEvents(int $page, User $author, DateTime $date, array $filters): PaginationInterface;

    public function save(Event $event): void;

    public function delete(Event $event): void;

    #public function update(Event $event): void;

}
