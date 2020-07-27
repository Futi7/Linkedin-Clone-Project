<?php

namespace App\Repository;

use App\Entity\Devicons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Devicons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devicons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devicons[]    findAll()
 * @method Devicons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviconsRepository extends ServiceEntityRepository
{




    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM App:Devicons e
                WHERE e.title LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }





    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devicons::class);
    }

    // /**
    //  * @return Devicons[] Returns an array of Devicons objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Devicons
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
