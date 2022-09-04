<?php
/**
 * Tag repository.
 */

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
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
    public const PAGINATOR_ITEMS_PER_PAGE = 20;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry ManagerRegistry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
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
                'partial tag.{id, title}'
            );
    }

    /**
     * Add entity.
     *
     * @param Tag  $entity Tag
     * @param bool $flush  bool
     */
    public function add(Tag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Save entity.
     *
     * @param Tag $tag Tag entity
     */
    public function save(Tag $tag): void
    {
        $this->_em->persist($tag);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Tag $tag Tag entity
     */
    public function delete(Tag $tag): void
    {
        $this->_em->remove($tag);
        $this->_em->flush();
    }

    /**
     * Remove entity.
     *
     * @param Tag  $entity Tag
     * @param bool $flush  bool
     */
    public function remove(Tag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Finds one Tag by given id.
     *
     * @param int $value Id of tag
     *
     * @return Tag|null Tag
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneById($value): ?Tag
    {
        $queryBuilder = $this->queryAll();

        return $queryBuilder
            ->andWhere('tag.id = :id')
            ->setParameter('id', $value)
            ->getQuery()
            ->getOneOrNullResult();
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
        return $queryBuilder ?? $this->createQueryBuilder('tag');
    }
//    /**
//     * @return Tag[] Returns an array of Tag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tag
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
