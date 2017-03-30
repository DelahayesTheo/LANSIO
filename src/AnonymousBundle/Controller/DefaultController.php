<?php

namespace AnonymousBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $userRepository = $em->getRepository('UserBundle:User');
        $inviteRepository = $em->getRepository('UserBundle:Invite');

        $invites = $inviteRepository->findBy(array(), array("lastName" => "ASC"));
        $users = $userRepository->findBy(array("isComing" => true), array("lastName" => "ASC"));

        return $this->render('AnonymousBundle:Default:index.html.twig', array(
            "invites" => $invites,
            "users" => $users
        ));
    }
}
