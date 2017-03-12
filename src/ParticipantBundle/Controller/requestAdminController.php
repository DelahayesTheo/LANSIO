<?php

namespace ParticipantBundle\Controller;

use ParticipantBundle\Form\Type\requestAdminGameType;
use ParticipantBundle\Entity\requestAdminGame;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Platform;

class requestAdminController extends Controller
{
    /**
     * @Route("/lister-demande/",
     *     name="user_list_request_game")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listRequestsAdminAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        $requestGameRepository = $em->getRepository('ParticipantBundle:requestAdminGame');

        $answeredRequests = $requestGameRepository->findRequestResolved($user->getId());
        $notAnsweredRequests = $requestGameRepository->findBy(array("user" => $user->getId(), "status" => 0));

        return $this->render("ParticipantBundle:Demande:listrequest.html.twig", array(
            "answeredRequests" => $answeredRequests,
            "notAnsweredRequests" => $notAnsweredRequests

        ));
    }

}