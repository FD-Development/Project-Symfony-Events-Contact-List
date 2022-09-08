<?php

/**
 * Event service interface.
 */

namespace App\Service;

use App\Entity\Event;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface EventServiceInterface.
 */
interface EventServiceInterface
{
    /**
     * Get paginated list for specified user.
     *
     * @param int                $page    Page number
     * @param User|UserInterface $author  Author
     * @param array<string, int> $filters Array of potential filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User|UserInterface $author, array $filters = []): PaginationInterface;

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
    public function getEventsByDate(int $page, User|UserInterface $author, DateTime $date, array $filters): PaginationInterface;

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
    public function getUpcomingEvents(int $page, User|UserInterface $author, DateTime $date, array $filters): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Event $event Event entity
     */
    public function save(Event $event): void;

    /**
     * Delete entity.
     *
     * @param Event $event Event entity
     */
    public function delete(Event $event): void;

    // public function update(Event $event): void;
}
