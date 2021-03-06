<?php

namespace ParticipantBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * bringedEquipmentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class bringedEquipmentRepository extends EntityRepository
{
    public function findAllBringedEquipmentSum()
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('e as equipment, SUM(b.quantity) AS totalQuantity')
            ->from('AdminBundle:Equipment', 'e')
            ->innerJoin('e.bringed', 'b')
            ->groupBy('e.id');


        return $result = $query->getQuery()->getResult();

    }
}
