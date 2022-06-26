<?php

/**
 * Contact service interface.
 */

namespace App\Service;

use App\Entity\Contact;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ContactServiceInterface.
 */
interface ContactServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    public function save(Contact $contact): void;

    public function delete(Contact $contact): void;

    #public function update(Contact $contact): void;

}
