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

    public function findSumEquipment()
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('SUM(u.needScreen) as nbScreenNeeded, SUM(u.needMouse) as nbMouseNeeded, 
            SUM(u.needKeyboard) as nbKeyboardNeeded, SUM(u.needNetworkCable) as nbNetworkCableNeeded')
            ->from("UserBundle:User", "u");

        $result = $query->getQuery()->getResult();
        return $result[0];
    }

    public function findSumEquipmentGuest()
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('SUM(i.needScreen) as nbScreenNeeded, SUM(i.needMouse) as nbMouseNeeded, 
            SUM(i.needKeyboard) as nbKeyboardNeeded, SUM(i.needNetworkCable) as nbNetworkCableNeeded')
            ->from("UserBundle:Invite", "i");

        $result = $query->getQuery()->getResult();
        return $result[0];
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

    public function countAllGuest()
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('COUNT(i.id)')
            ->from("UserBundle:Invite", "i");

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
