<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function save(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Property[] Returns an array of Property objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Property
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findLocation(): array
    {
        $qb = $this->createQueryBuilder('property');

        $qb->addSelect('property')
            ->join('property.payment', 'payment')
            ->where('payment.name != :payment_name')
            ->setParameter(':payment_name', 'achat');

        return $qb->getQuery()->getResult();
    }
    public function findAchat(): array
    {
        $qb = $this->createQueryBuilder('property');

        $qb->addSelect('property')
            ->join('property.payment', 'payment')
            ->where('payment.name = :payment_name')
            ->setParameter(':payment_name', 'achat');

        return $qb->getQuery()->getResult();
    }

    public function findByFilter($data): array
    {
        $qb = $this->createQueryBuilder('property');

        $qb->addSelect('property');

        if ($data['city']) {
            $qb->andWhere('property.city LIKE :name')
                ->setParameter(':name', '%'.$data['city'].'%');
        }

        if ($data['zipcode']) {
            $qb->andWhere('property.zipcode LIKE :name')
                ->setParameter(':name', $data['zipcode'].'%');
        }

        if ($data['minPrice']) {
            $qb->andWhere('property.price >= :minPrice')
                ->setParameter(':minPrice', $data['minPrice']);
        }

        if ($data['maxPrice']) {
            $qb->andWhere('property.price <= :maxPrice')
                ->setParameter(':maxPrice', $data['maxPrice']);
        }

        if ($data['minSurface']) {
            $qb->andWhere('property.surface >= :minSurface')
                ->setParameter(':minSurface', $data['minSurface']);
        }

        if ($data['maxSurface']) {
            $qb->andWhere('property.surface <= :maxSurface')
                ->setParameter(':maxSurface', $data['maxSurface']);
        }

        if ($data['category']) {
            $qb->andWhere('property.category = :category')
                ->setParameter(':category', $data['category']);
        }

        if ($data['payment']) {
            $qb->andWhere('property.payment = :payment')
                ->setParameter(':payment', $data['payment']);
        }

        if ($data['minRoom']) {
            $qb->andWhere('property.Room >= :minRoom')
                ->setParameter(':minRoom', $data['minRoom']);
        }

        if ($data['maxRoom']) {
            $qb->andWhere('property.Room <= :maxRoom')
                ->setParameter(':maxRoom', $data['maxRoom']);
        }

        return $qb->getQuery()->getResult();
    }
}
