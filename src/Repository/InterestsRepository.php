<?php

namespace App\Repository;

use App\Entity\Interests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Interests|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interests|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interests[]    findAll()
 * @method Interests[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interests::class);
    }

    // /**
    //  * @return Interests[] Returns an array of Interests objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interests
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
