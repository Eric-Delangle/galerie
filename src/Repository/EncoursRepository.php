<?php

namespace App\Repository;

use App\Entity\Encours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Encours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Encours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Encours[]    findAll()
 * @method Encours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Encours::class);
    }

    // /**
    //  * @return Encours[] Returns an array of Encours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Encours
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
