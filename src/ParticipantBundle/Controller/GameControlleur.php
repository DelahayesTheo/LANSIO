<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
class GameControlleur extends Controller
{
    /**
     * @Route("/lister_jeux/",
     *     name="user_list_game")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listGameAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $gameRepository = $em->getRepository("AdminBundle:Game");
        $games = $gameRepository->findAll();

        return $this->render("ParticipantBundle:Game:list.html.twig", array(
            "games" => $games
        ));
    }

    /**
     * @Route("/enlever-jeu-joue/{game}/",
     *     name="user_remove_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_MANAGER')")
     */
    public function removeGamePlayedAction(Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        $user->removeGamePlayed($game);

        return $this->redirectToRoute("user_list_game");
    }

    /**
     * @Route("/jouer-jeu/{game}/",
     *     name="user_play_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_MANAGER')")
     */
    public function addGamePlayedAction(Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        $user->setGamesPlayed($game);
        $em->flush();

        return $this->redirectToRoute("user_list_game");
    }
}