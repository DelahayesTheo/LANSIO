<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NeededEquipment extends Controller
{
    /**
     * @Route("/synthese-equipement-emprunte/",
     *     name="admin_equipment_needed")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $userRepository = $em->getRepository("UserBundle:User");
        $equipmentNeeded = $userRepository->findSumEquipment();
        return $this->render('AdminBundle:EquipmentNeeded:index.html.twig', array(
            "equipmentNeeded" => $equipmentNeeded
        ));
    }
}