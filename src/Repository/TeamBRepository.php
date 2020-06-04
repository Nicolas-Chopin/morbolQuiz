<?php

namespace App\Repository;

use App\Entity\TeamB;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamB|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamB|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamB[]    findAll()
 * @method TeamB[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamBRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamB::class);
    }

    // /**
    //  * @return TeamB[] Returns an array of TeamB objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeamB
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
