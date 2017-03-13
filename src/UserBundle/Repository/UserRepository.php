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

    public function countAllUser()
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from("UserBundle:User", "u")
            ->where("u.isComing = :true")
            ->setParameter("true", true);

        $result = $query->getQuery()->getResult();
        return $result[0][1];
    }

    public function countAllUserEating()
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from("UserBundle:User", "u")
            ->where("u.isEating = :true")
            ->setParameter("true", true);

        $result = $query->getQuery()->getResult();
        return $result[0][1];
    }
}
