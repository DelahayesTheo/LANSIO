<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="...")
     */
    public function indexAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $gameRepository = $em->getRepository('AdminBundle:Game');
        $userRepository = $em->getRepository('UserBundle:User');

        $countUser = $userRepository->countAllUser();
        $countEating = $userRepository->countAllUserEating();
        $countGame = $gameRepository->countGamePlayed();

        return $this->render('UserBundle:Default:index.html.twig', array(
            "nbUsers" => $countUser,
            "nbPizza" => $countEating,
            "nbGamePlayed" => $countGame
        ));
    }
}
