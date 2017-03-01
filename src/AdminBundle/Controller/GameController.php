<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Game;
use AdminBundle\Entity\Platform;
use AdminBundle\Form\Type\GameType;
use AdminBundle\Form\Type\PlatformType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
            $successMessage = "le jeu ". $game->getName()  ." à bien été rajouté";
            $em->persist($game);
            $em->flush();

            $form = $this->createForm(new GameType(), $game);
        }
        return $this->render('AdminBundle:Game:add.html.twig', array(
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ));
    }

    /**
     * @Route("/modifier-jeu/{game}",
     *     name="admin_modify_game")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function modifyGameAction(Request $request, Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $form = $this->createForm(new GameType(), $game);

        if ($form->handleRequest($request)->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('admin_list_game');
        }

        return $this->render('AdminBundle:Game:modify.html.twig', array(
            'form' => $form->createView()
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
        $roles = array();

        foreach ($this->container->getParameter('security.role_hierarchy.roles') as $name => $rolesHierarchy) {
            $roles[$name] = $name;

            foreach ($rolesHierarchy as $role) {
                if (!isset($roles[$role])) {
                    $roles[$role] = $role;
                }
            }
        }
        return $this->render('AdminBundle:Game:list.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * @Route("/modifier-plateforme/{platform}",
     *     name="admin_modify_platform")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function modifyPlatformAction(Request $request, Platform $platform)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $form = $this->createForm(new PlatformType(), $platform);

        if ($form->handleRequest($request)->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('admin_list_platform');
        }

        return $this->render('AdminBundle:Platform:modify.html.twig', array(
            'form' => $form->createView()
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
        $form = $this->createForm(new PlatformType(), $platform);

        if ($form->handleRequest($request)->isValid())
        {
            $successMessage = "la platforme ". $platform->getWording() ." à bien été rajouté";
            $em->persist($platform);
            $em->flush();

            $form = $this->createForm(new PlatformType(), $platform);
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