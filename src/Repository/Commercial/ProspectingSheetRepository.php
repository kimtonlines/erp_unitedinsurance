<?php

namespace App\Repository\Commercial;

use App\Entity\Commercial\ProspectingSheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProspectingSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProspectingSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProspectingSheet[]    findAll()
 * @method ProspectingSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectingSheetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProspectingSheet::class);
    }

    // /**
    //  * @return ProspectingSheet[] Returns an array of ProspectingSheet objects
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
    public function findOneBySomeField($value): ?ProspectingSheet
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
