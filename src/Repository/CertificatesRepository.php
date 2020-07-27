<?php

namespace App\Repository;

use App\Entity\Certificates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Certificates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Certificates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Certificates[]    findAll()
 * @method Certificates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertificatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Certificates::class);
    }

    // /**
    //  * @return Certificates[] Returns an array of Certificates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Certificates
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
