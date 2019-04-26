<?php

namespace App\Repository;

use App\Entity\Depute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Depute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Depute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Depute[]    findAll()
 * @method Depute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeputeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Depute::class);
    }

    // /**
    //  * @return Depute[] Returns an array of Depute objects
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
    public function findOneBySomeField($value): ?Depute
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
