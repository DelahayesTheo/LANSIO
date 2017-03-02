<?php
namespace ParticipantBundle\Repository;

use Doctrine\ORM\EntityRepository;

class requestAdminRepository extends EntityRepository
{
    public function findRequestById($idRequest)
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('r, u')
            ->from('ParticipantBundle:requestAdmin', 'r')
            ->join('UserBundle:User', 'u')
            ->where('r.id = :idRequest')
            ->setParameter('idRequest', $idRequest);

        return $result = $query->getQuery()->getResult();
    }
    public function findNumberRequestResolved($idUser)
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(r.id)')
            ->from('ParticipantBundle:requestAdmin', 'r')
            ->join('UserBundle:User', 'u')
            ->where('r.resolved = :true')
            ->andWhere('u.id = :idUser')
            ->groupBy("u.id")
            ->setParameter('idUser', $idUser)
            ->setParameter('true', true);

        return $result = $query->getQuery()->getResult();

    }
}