<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\GameType;
use AdminBundle\Entity\Game;
use ParticipantBundle\Entity\requestAdminGame;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RequestController extends Controller
{
    /**
     * @Route("/lister-requetes/",
     *     name="admin_list_request")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listRequestAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $requestGameRepository = $em->getRepository("ParticipantBundle:requestAdminGame");

        $requestsToResolve = $requestGameRepository->findBy(array("status" => 0));

        return $this->render("AdminBundle:Request:list.html.twig", array(
            "requests"=> $requestsToResolve
        ));
    }

    /**
     * @Route("/supprimer-requete/{requestGame}/",
     *     name="admin_reject_request_game",
     *     options={"expose" = true})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function rejectRequestAction(requestAdminGame $requestGame)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $requestGame->setStatus(-1);
        $em->flush();

        return $this->redirectToRoute("admin_list_request");
    }
    /**
     * @Route("/accepter-requete/{requestGame}/",
     *     name="admin_accept_request_game")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function acceptRequestGameAction(requestAdminGame $requestGame, Request $request)
    {
        $successMessage = null;
        $em = $this
            -> getDoctrine()
            -> getManager();

        $game = new Game();
        $game->setKind($requestGame->getKind());
        $game->setName($requestGame->getName());
        $game->setPlatform($requestGame->getPlatform());
        $game->setNbMaxPlayer($requestGame->getNbMaxPlayer());
        $form = $this->createForm(new GameType(), $game);

        if ($form->handleRequest($request)->isValid()) {
            $requestGame->setStatus(1);
            $em->persist($game);
            $em->persist($requestGame);
            $em->flush();
            return $this->redirectToRoute("admin_list_request");
        }

        return $this->render("AdminBundle:Game:add.html.twig", array(
            "successMessage" => null,
            "form" => $form->createView()
        ));
    }
}