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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
    public function listGameAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
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

        return $this->render('AdminBundle:Game:list.html.twig', array(
            'research' => $research->createView(),
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
    public function listPlatformAction()
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

    /**
     * @Route("/supprimer-jeu/{game}",
     *     name="admin_delete_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteGameAction(Request $request, Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $em->remove($game);
        $em->flush();

        return $this->redirectToRoute("admin_list_game");
    }
}