<?php
namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{
    public function findAllGamesOrderByName()
    {
        $em = $this
            ->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('g')
            ->from('AdminBundle:Game', 'g')
            ->orderBy('g.name');

        return $query->getQuery()->getResult();
    }

    public function countGamePlayed()
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(g.id)')
            ->from('AdminBundle:Game', 'g')
            ->where('g.usersPlaying IS NOT EMPTY');

        $result = $query->getQuery()->getResult();
        return $result[0][1];
    }
}
