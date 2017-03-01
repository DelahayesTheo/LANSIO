<?php
// src/AppBundle/Repository/ProductRepository.php
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
}
