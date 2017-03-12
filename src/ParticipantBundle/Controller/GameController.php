<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\Game;
use ParticipantBundle\Entity\requestAdminGame;
use ParticipantBundle\Form\Type\requestAdminGameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
class GameController extends Controller
{
    /**
     * @Route("/jeux/",
     *     name="user_game_dashboard")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $requestAdminGame = new requestAdminGame();
        $user = $this->getUser();
        $form = $this->createForm(new requestAdminGameType(), $requestAdminGame);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $requestAdminGame->setUser($user);
            $requestAdminGame->setStatus(0);
            $em->persist($requestAdminGame);
            $em->flush();
            $this->addFlash(
                'notice',
                "La demande à été prise en compte"
            );
            return $this->redirectToRoute('user_game_dashboard', array('request'=>null));
        }

        return $this->render("ParticipantBundle:Game:index.html.twig",array(
            "form" => $form->createView()
    ));
    }
    /**
     * @Route(name="user_list_game",
     *     options={"expose" = true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function listGameAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();
        $gameRepository = $em->getRepository("AdminBundle:Game");
        $games = $gameRepository->findAll();

        return $this->render("ParticipantBundle:Game:list.html.twig", array(
            "games" => $games,
            "user" => $user
        ));
    }

    /**
     * @Route("/enlever-jeu-joue/{game}/",
     *     name="user_remove_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function removeGamePlayedAction(Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        $game->removeUsersPlaying($user);
        $user->removeGamePlayed($game);
        $em->flush();

        return $this->redirectToRoute("user_list_game");
    }

    /**
     * @Route("/jouer-jeu/{game}/",
     *     name="user_play_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function addGamePlayedAction(Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();
        $game->setUsersPlaying($user);
        $user->setGamesPlayed($game);
        $em->flush();

        return $this->redirectToRoute("user_list_game");
    }
}