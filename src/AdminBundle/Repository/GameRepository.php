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

    public function findAllGamesResearch($name, $kind)
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('g')
            ->from('AdminBundle:Game', 'g')
            ->where('g.name LIKE :name')
            ->andWhere('g.kind LIKE :kind')
            ->setParameter('name', '%' . $name . '%')
            ->setParameter('kind', '%' . $kind . '%')
            ->orderBy('g.name');

        return $query->getQuery()->getResult();
    }

    public function findAllKind()
    {
        $em = $this
            ->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('DISTINCT(g.kind) as aKind')
            ->from('AdminBundle:Game', 'g')
            ->orderBy('g.kind');

        return $query->getQuery()->getResult();
    }
}
