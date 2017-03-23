<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\Game;
use ParticipantBundle\Entity\requestAdminGame;
use ParticipantBundle\Form\Type\requestAdminGameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            "form" => $form->createView(),
            "request" => $request
    ));
    }
    /**
     * @Route("/test/",
     *     name="user_list_game",
     *     options={"expose" = true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function listGameAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();
        $gameRepository = $em->getRepository("AdminBundle:Game");

        $data = array();
        $options = array();
        $kinds = $gameRepository->findAllKind();
        foreach ($kinds as $kind) {
            $options[$kind['aKind']] = $kind['aKind'];
        }
        $research = $this->createFormBuilder($data)
            ->add('name', TextType::class, array('required' => false))
            ->add('kind', ChoiceType::class, array(
                'choices' => $options
            ,
                'required' => false,
                'group_by' => null,
            ))
            ->add('save', SubmitType::class)
            ->getForm();

        $research->handleRequest($request);
        if ($research->isValid() && $research->isSubmitted()) {
            $data = $research->getData();
            $games = $gameRepository->findAllGamesResearch($data['name'], $data['kind']);
        } else {
            $games = $gameRepository->findAll();
        }

        return $this->render("ParticipantBundle:Game:list.html.twig", array(
            "research" => $research->createView(),
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

    /**
     * @Route("/lister_participant_jeu/{game}/{path}/",
     *     name="user_game_list_players")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listPlayersAction(Game $game, $path)
    {
        return $this->render('ParticipantBundle:Game:listUsers.html.twig', array(
            "game" => $game,
            "path" => $path
        ));
    }
}