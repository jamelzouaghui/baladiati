<?php

namespace App\Repository;

use App\Entity\AbstractGMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AbstractGMap|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractGMap|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractGMap[]    findAll()
 * @method AbstractGMap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractGMapRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, AbstractGMap::class);
    }

    // /**
    //  * @return AbstractGMap[] Returns an array of AbstractGMap objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('a')
      ->andWhere('a.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('a.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?AbstractGMap
      {
      return $this->createQueryBuilder('a')
      ->andWhere('a.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */

    public function findReclamationsUnread() {
        return $this->createQueryBuilder('a')
                        ->andWhere('a.publicated = :val')
                        ->setParameter('val', '1')
                        ->getQuery()
                        ->getResult();
    }

}
