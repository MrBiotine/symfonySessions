<?php
class SampleRepository extends ServiceEntityRepository{

    public function findByStagiairesNotInSession(int $id)
    {
        $em = $this->getEntityManager(); // get the EntityManager
        $sub = $em->createQueryBuilder(); // create a new QueryBuilder

        $qb = $sub; // use the same QueryBuilder for the subquery

        $qb->select('s') // select the root alias
            ->from('App\Entity\Stagiaire', 's') // the subquery is based on the same entity
            ->leftJoin('s.session_stagiaire', 'se') // join the subquery
            ->where('se.id = :id');

        $sub = $em->createQueryBuilder(); // create a new QueryBuilder

        $sub->select('st')->from('App\Entity\Stagiaire', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id', $id);

        return $sub->getQuery()->getResult();
    }
}
