<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */

    public function findOrderAuthor(): array
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.author', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findRef($value): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.ref LIKE :ref')
            ->setParameter('ref', $value . '%')
            ->getQuery()
            ->getResult();
    }

    public function findBook2023(): array
    {
        return $this->createQueryBuilder('b')
            ->join('b.author', 'a')
            ->addSelect('b', 'a')
            ->where('b.publicationDate < :targetDate')
            ->andWhere('a.nbBooks > 35')
            ->setParameter('targetDate', new \DateTime('2023-01-01'))
            ->getQuery()
            ->getResult();
    }
    public function changeRomance(): int
    {
        $authorName = "William Shakesp";
        $newCategory = "Romance";

        $query = $this->createQueryBuilder('b')
            ->join('b.author', 'a')
            ->addSelect('b', 'a')
            ->select('a.id')
            ->where('a.username LIKE :author')
            ->setParameter('author', $authorName)
            ->getQuery()
            ->getResult();
        
            $idAuthor = $query[0]['id'];


        return $this->createQueryBuilder('b')
            ->update(Book::class, 'b')
            ->set('b.category', ':newCategory')
            ->where('b.author = :author')
            ->setParameter('newCategory', $newCategory)
            ->setParameter('author', $idAuthor)
            ->getQuery()
            ->execute();
    }
    public function findScience(): int
    {
      $em = $this->getEntityManager();
      $query = $em->createQuery("SELECT COUNT(DISTINCT b.ref) FROM App\Entity\Book b WHERE b.category LIKE 'Science-Fiction' ");
      return $query->getSingleScalarResult();
    }
    public function deuxDate(): array
    {
      $em = $this->getEntityManager();
      $query = $em->createQuery("SELECT b FROM App\Entity\Book b WHERE b.publicationDate BETWEEN '2014-01-01' AND '2018-12-31' ");
      return $query->getResult();
    }





    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
