<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SupportRequestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SupportRequestRepository extends EntityRepository
{
    public function countSupportRequestNotDone()
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(sr.id)')
            ->from('AdminBundle:SupportRequest', 'sr')
            ->where('sr.status = :zero')
            ->setParameter('zero', 0);

        $result = $query->getQuery()->getResult();
        return $result[0][1];
    }
}
