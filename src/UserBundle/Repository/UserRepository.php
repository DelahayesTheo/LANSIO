<?php
// src/AppBundle/Repository/ProductRepository.php
namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllUserOrderByName()
    {
        $em= $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('u')
            ->from("UserBundle:User", "u")
            ->orderBy("u.username");

        return $query->getQuery()->getResult();
    }

}
