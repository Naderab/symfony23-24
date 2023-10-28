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

public function getBooksOrdredByPublicationDate(){
    return $this->createQueryBuilder('b')
                ->orderBy('b.publicationDate','DESC')
                ->getQuery()
                ->getResult();
}

public function getBooksByTitle($title){
    return $this->createQueryBuilder('b')
                 ->where('b.title LIKE :title')
                 ->orWhere('b.ref LIKE :ref')
                 ->orWhere('b.category LIKE :cat')
                 ->setParameter('title','%'.$title.'%')
                 ->setParameter('ref','%'.$title.'%')
                 ->setParameter('cat','%'.$title.'%')
                 ->getQuery()
                 ->getResult(); //[]
}

public function getNbBooksByCategory($category){
    $manager = $this->getEntityManager();
    $req = $manager->createQuery('SELECT COUNT(b) FROM App\Entity\Book b WHERE b.category LIKE :cat')
    ->setParameter('cat',$category);
    return $req->getSingleScalarResult();

}

public function getBookByPublicationDate($date1,$date2){
    $manager = $this->getEntityManager();
    $req = $manager->createQuery('select b from App\Entity\Book b where b.publicationDate between :date1 and :date2')
    ->setParameter('date1',$date1)
    ->setParameter('date2',$date2);
    return $req->getResult();
}

}
