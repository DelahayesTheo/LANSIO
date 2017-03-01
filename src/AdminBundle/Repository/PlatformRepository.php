<?php
namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlatformRepository extends EntityRepository
{
    public function queryFindAllPlatformOrderByName()
    {
        $em = $this
            ->getEntityManager();

        $query = $em ->createQueryBuilder()
            ->select('p')
            ->from('AdminBundle:Platform', 'p')
            ->orderBy('p.wording');

        return $query;
    }

    public function findAllPlatformOrderByName()
    {
        $em = $this
            ->getEntityManager();

        $query = $em ->createQueryBuilder()
            ->select('p')
            ->from('AdminBundle:Platform', 'p')
            ->orderBy('p.wording');

        return $query->getQuery()->getResult();
    }
}