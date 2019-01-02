<?php

namespace App\Repository\Commercial;

use App\Entity\Commercial\TypeProspection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeProspection|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeProspection|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeProspection[]    findAll()
 * @method TypeProspection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeProspectionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeProspection::class);
    }

    // /**
    //  * @return TypeProspectionType[] Returns an array of TypeProspectionType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeProspectionType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
