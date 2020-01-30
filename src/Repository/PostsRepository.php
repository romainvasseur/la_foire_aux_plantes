<?php

namespace App\Repository;

use App\Entity\Posts;
use App\Entity\PostSearch;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    /**
    * @return Posts[]
    */
    public function findLatest()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findAllGood()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllPages(PostSearch $search){
        $query = $this->findVisibleQuery();

        if ($search->getDpt()) {
            $query = $query
                ->andWhere('p.dpt = :dpt')
                ->setParameter('dpt', $search->getDpt());
        }

        if ($search->getPosttype()) {
            $query = $query
                ->andWhere('p.posttype = :posttype')
                ->setParameter('posttype', $search->getPosttype());
        }

        if ($search->getCategory()) {
            $query = $query
                ->andWhere('p.category = :category')
                ->setParameter('category', $search->getCategory());
        }

        if ($search->getDescription()) {
            $query = $query
                ->andWhere('p.description LIKE :description')
                ->setParameter('description', '%'.$search->getDescription().'%');
        }

        if ($search->getTitle()) {
            $query = $query
                ->andWhere('p.title LIKE :title')
                ->setParameter('title', '%'.$search->getTitle().'%');
        }

        return $query->getQuery();
    }

    private function findVisibleQuery(){
        return $this->createQueryBuilder('p')
                    ->where('p.postal > 0')
                    ->orderBy('p.created_at', 'DESC');
    }

    // /**
    //  * @return Posts[] Returns an array of Posts objects
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
    public function findOneBySomeField($value): ?Posts
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
