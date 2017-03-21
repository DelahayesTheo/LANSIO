<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $gameRepository = $em->getRepository('AdminBundle:Game');
        $userRepository = $em->getRepository('UserBundle:User');

        $countUser = $userRepository->countAllUser();
        $countEating = $userRepository->countAllUserEating();
        $countGame = $gameRepository->countGamePlayed();
        $countGuest = $userRepository->countAllGuest();

        return $this->render('UserBundle:Default:index.html.twig', array(
            "nbUsers" => $countUser,
            "nbPizza" => $countEating,
            "nbGamePlayed" => $countGame,
            "nbGuest" => $countGuest
        ));
    }
}
