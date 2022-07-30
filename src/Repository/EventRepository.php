<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;




    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('event');
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial event.{id, dateFrom, timeFrom, dateTo, timeTo, title, description}',
                'partial category.{id, title}'
            )
            ->join('event.category', 'category')
            ->orderBy('event.dateFrom, event.timeFrom', 'DESC');
    }

    /**
     * Query all records by specific user.
     *
     * @param User $user
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryByAuthor(User $user): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
            'partial event.{id, dateFrom, dateTo, timeFrom, timeTo, title, category}',
            'partial category.{id, title}'
        )
            ->join('event.category', 'category')
            ->where('event.author = :author')
            ->setParameter('author', $user);
    }

    /**
     * Query all records that contain specified date.
     *
     * @param User $user
     * @param string $date
     *
     * @return QueryBuilder Query builder
     */
    public function queryByDate(User $user, string $date) :QueryBuilder
    {
        $queryBuilder = $this->queryByAuthor($user);
        $queryBuilder
            ->andWhere($queryBuilder->expr()->between(
                ':date',
                'event.dateFrom',
                'event.dateTo'
            )
            )
            ->orderBy('event.dateFrom,event.timeFrom', 'DESC')
            ->setParameter('date', $date );
        return $queryBuilder;
    }

    /**
     * Query all records that start in the after the specified date.
     *
     * @param User $user
     * @param string $date
     *
     * @return QueryBuilder Query builder
     */
    public function queryUpcoming(User $user, string $date) :QueryBuilder
    {
        $queryBuilder = $this->queryByAuthor($user);

        $queryBuilder
            ->andWhere('event.dateFrom > :date')
            ->orderBy('event.dateFrom,event.timeFrom', 'DESC')
            ->setParameter('date', $date );
        return $queryBuilder;
    }

    /**
     * Save entity.
     *
     * @param Event $event Event entity
     */
    public function save(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Event $event Event entity
     */
    public function delete(Event $event): void
    {
        $this->_em->remove($event);
        $this->_em->flush();
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Count events by category.
     *
     * @param Category $category Category
     *
     * @return int Number of events in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('event.id'))
            ->where('event.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countByTag(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('event.id'))
            ->where('event.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
