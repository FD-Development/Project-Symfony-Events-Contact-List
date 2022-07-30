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
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface;

    /**
     * Get paginated events list corresponding to specified date.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getEventsByDate(int $page, User $author, DateTime $date): PaginationInterface;

    /**
     * Get paginated events list corresponding to specified date.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getUpcomingEvents(int $page, User $author, DateTime $date): PaginationInterface;

    public function save(Event $event): void;

    public function delete(Event $event): void;

    #public function update(Event $event): void;

}
