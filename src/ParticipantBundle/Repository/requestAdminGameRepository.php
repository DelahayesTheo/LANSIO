<?php
namespace ParticipantBundle\Repository;

use Doctrine\ORM\EntityRepository;

class requestAdminGameRepository extends EntityRepository
{

    public function findRequestResolved($idUser)
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('r')
            ->from('ParticipantBundle:requestAdminGame', 'r')
            ->join('UserBundle:User', 'u')
            ->where('r.status = :minusOne')
            ->orWhere('r.status = :one')
            ->andWhere('u.id = :idUser')
            ->setParameter('idUser', $idUser)
            ->setParameter('minusOne', -1)
            ->setParameter('one', 1);

        return $result = $query->getQuery()->getResult();
    }

    public function countRequestNotDone()
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(rag.id)')
            ->from('ParticipantBundle:requestAdminGame', 'rag')
            ->where('rag.status = :zero')
            ->setParameter('zero', 0);

        $result = $query->getQuery()->getResult();
        return $result[0][1];
    }

}