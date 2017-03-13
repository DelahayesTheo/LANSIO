<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/",
     * name="admin_dashboard")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $UserRepository = $em->getRepository("UserBundle:User");
        $users = $UserRepository->findAllUserOrderByName();

        return $this->render('AdminBundle:Default:index.html.twig', array(
            "users" => $users
        ));
    }
}