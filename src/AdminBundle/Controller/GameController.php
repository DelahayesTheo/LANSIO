<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class GameController extends Controller
{
    /**
     * @Route("/ajouter-jeu/",
     *     name="admin_add_game")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addGameAction(Request $request)
    {
        $game = new Game();
        $form = $this->createFormBuilder($game)
            ->add('name', TextType::class)
            ->add('platform', TextType::class)
            ->add('nbMaxPlayer', IntegerType::class)
            ->add('kind', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();
        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
        }
        return $this->render('AdminBundle:Game:add.html.twig', array(
            'form' => $form->createView(),
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
}