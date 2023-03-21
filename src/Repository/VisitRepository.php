<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\User;
use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visit>
 *
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    public function save(Visit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Visit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFutureVisit(Property|User $entity = null): array
    {
        $qb = $this->createQueryBuilder('visit');

        $qb->addSelect('property')
            ->join('visit.property', 'property')
            ->where('visit.dateStart > :today');

        if ($entity instanceof Property) {
            $qb->andWhere('property.id = :property_id')
                ->setParameter(':property_id', $entity->getId());
        }
        elseif ($entity instanceof User) {
            $qb->join('visit.visitor', 'visitor')
                ->andWhere('visitor.id = :user_id')
                ->setParameter(':user_id', $entity->getId());
        }

        $qb->orderBy('visit.dateStart', 'ASC')
            ->setParameter(':today', new \DateTime());

        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Visit[] Returns an array of Visit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Visit
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
