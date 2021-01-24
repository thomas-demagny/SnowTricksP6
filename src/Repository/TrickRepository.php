<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }


    public function findTrickWithCategories($id)
    {
        return $this->createQueryBuilder('t')
            ->addSelect('ca')
            ->leftJoin('t.categories', 'ca')
            ->Where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findTrickByCategory($id)
    {
        return $this->createQueryBuilder('t')
->innerJoin('t.categories', 'ca')
            ->Where('ca.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
