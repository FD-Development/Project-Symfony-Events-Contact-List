<?php

/**
 * Contact service interface.
 */

namespace App\Service;

use App\Entity\Contact;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface ContactServiceInterface.
 */
interface ContactServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int                $page Page number
     * @param User|UserInterface $user User entity
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User|UserInterface $user): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Contact $contact Contact entity
     */
    public function save(Contact $contact): void;

    /**
     * Delete entity.
     *
     * @param Contact $contact Contact entity
     */
    public function delete(Contact $contact): void;

    // public function update(Contact $contact): void;
}
