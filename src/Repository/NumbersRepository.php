<?php

namespace App\Repository;

use App\Entity\Numbers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Numbers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Numbers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Numbers[]    findAll()
 * @method Numbers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumbersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Numbers::class);
    }

    // /**
    //  * @return Numbers[] Returns an array of Numbers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Numbers
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
