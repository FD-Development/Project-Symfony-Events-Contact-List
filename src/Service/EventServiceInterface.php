<?php

/**
 * Event service interface.
 */

namespace App\Service;

use App\Entity\Event;
use Knp\Component\Pager\Pagination\PaginationInterface;

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
    public function getPaginatedList(int $page): PaginationInterface;

    public function save(Event $event): void;

    #public function delete(Event $event): void;

    #public function update(Event $event): void;

}
