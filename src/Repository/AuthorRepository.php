<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */

    public function findOrderEmail(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function minMax($min,$max): array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT a FROM App\Entity\Author a WHERE a.nbBooks BETWEEN :min AND :max ")
                ->setParameter('min',$min)
                ->setParameter('max',$max);
        return $query->getResult();
    }
    public function deleteZero(): int
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("DELETE FROM App\Entity\Author a WHERE a.nbBooks = 0 ");  
        return $query->execute();
    }


    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
