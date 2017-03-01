<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Game;
use AdminBundle\Entity\Platform;
use AdminBundle\Form\Type\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GameController extends Controller
{
    /**
     * @Route("/ajouter-jeu/",
     *     name="admin_add_game")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addGameAction(Request $request)
    {
        $successMessage = null;
        $em = $this
            ->getDoctrine()
            ->getManager();
        $game = new Game();
        $form = $this->createForm(new GameType(), $game);

        if ($form->handleRequest($request)->isValid())
        {
            $em->persist($game);
            $em->flush();
            $successMessage = "le jeu à bien été rajouté";
            $form = $this->createForm(new GameType(), $game);
        }
        return $this->render('AdminBundle:Game:add.html.twig', array(
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ));
    }

    /**
     * @Route("/lister-jeu/",
     *     name="admin_list_game")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listGameAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $gameRepository = $em->getRepository("AdminBundle:Game");

        $games = $gameRepository->findAllGamesOrderByName();

        return $this->render('AdminBundle:Game:list.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * @Route("/ajouter-plateforme/",
     *     name="admin_add_platform")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addPlatformAction(Request $request)
    {
        $successMessage = null;
        $em = $this
            ->getDoctrine()
            ->getManager();

        $platform = new Platform();
        $form = $this->createFormBuilder($platform)
            ->add('code', TextType::class)
            ->add('wording', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        if ($form->handleRequest($request)->isValid())
        {
            $em->persist($platform);
            $em->flush();
            $successMessage = "la platforme à bien été rajouté";
        }

        return $this->render('AdminBundle:Platform:add.html.twig', array(
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ));

    }

    /**
     * @Route("/lister-plateforme/",
     *     name="admin_list_platform")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listPlatformAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $platformRepository = $em->getRepository('AdminBundle:Platform');

        $platforms = $platformRepository->findAllPlatformOrderByName();
        return $this->render('AdminBundle:Platform:list.html.twig', array(
            'platforms' => $platforms
        ));
    }
}