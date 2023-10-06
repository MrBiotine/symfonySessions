<?php

namespace App\Repository;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Programm;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    //display unregistered trainees //
    public function getNonSubscriber($session_id)
    {
        
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        // Selects all trainees registered in a session whose id is passed in parameters (sub query)
        $subQuery->select('t.id')
                ->from('App\Entity\Trainee;
                ', 't')
                ->join('t.trainee_session', 's')
                ->where('s.id = :id')
                ->setParameter('id', $session_id);

        $qb = $entityManager->createQueryBuilder();

        // main query (query builder)  : Selects all trained unregistred <=> all trainee listed minus trainee registred in a session
        $qb->select('tr')
        ->from('App\Entity\Trainee;
        ', 'tr')
        ->where($qb->expr()->notIn('tr.id', $subQuery->getDQL()))
        ->orderBy('tr.firstNameTrainee', 'ASC')
        ->setParameter('id', $session_id);

        //the function returns the result as an array of trainee objects
        return $qb->getQuery()->getResult();
    }
    public function findByTraineesNotInSession(int $id)
    {
        $em = $this->getEntityManager(); // get the EntityManager
        $sub = $em->createQueryBuilder(); // create a new QueryBuilder

        $qb = $sub; // use the same QueryBuilder for the subquery

        $qb->select('s') // select the root alias
            ->from('App\Entity\Trainee;
            ', 's') // the subquery is based on the same entity
            ->leftJoin('s.trainee_session', 'se') // join the subquery
            ->where('se.id = :id');

        $sub = $em->createQueryBuilder(); // create a new QueryBuilder

        $sub->select('st')->from('App\Entity\Trainee', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id', $id);

        return $sub->getQuery()->getResult();
    }
    
     //Display unused modules//
     public function getNonProgrammed($session_id)
    {
        
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        // Selects all programm made in a session whose id is passed in parameters (sub query)
        $subQuery->select('p.id')
                ->from('Programm', 'p')
                ->join('p.session', 's')
                ->where('s.id = :id')
                ->setParameter('id', $session_id);

        $qb = $entityManager->createQueryBuilder();

        // main query (query builder)  : Selects all programms not in session <=> all programms listed minus trainee registred in a session
        $qb->select('np')
        ->from('Programme', 'np')
        ->where($qb->expr()->notIn('np.id', $subQuery->getDQL()))
        ->orderBy('np.moduleDuration', 'DESC')
        ->setParameter('id', $session_id);

        //the function returns the result as an array of trainee objects
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
