<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Invite;
use UserBundle\Form\Type\InviteType;

class InviteController extends Controller
{
    /**
     * @Route("/invitation/gerer/",
     *     name="user_guest")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();
        if (!$user->hasGuest()) {
            return $this->redirectToRoute('user_guest_invite');
        }

        $invite = $user->getInvite();

        return $this->render('ParticipantBundle:Guest:index.html.twig', array(
            "invite" => $invite
        ));
    }

    /**
     * @Route("/invitation/inviter/",
     *     name="user_guest_invite")
     * @Security("is_granted('ROLE_USER')")
     */
    public function inviteAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        if ($user->hasGuest()) {
            return $this->redirectToRoute("user_guest");
        }

        $invite = new Invite();
        $form = $this->createForm(new InviteType(), $invite);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $invite->setIsComing(true);
            $user->setInvite($invite);

            $em->persist($invite);
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre invité est enregistré'
            );

            return $this->redirectToRoute('user_guest');
        }
        return $this->render('ParticipantBundle:Guest:indexNoGuest.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/invitation/supprimer-invite/",
     *     name="user_guest_delete",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function deleteGuestAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $user = $this->getUser();
        $guest = $user->getInvite();

        $user->setInvite(null);
        $em->remove($guest);
        $em->flush();

        $this->addFlash(
            'notice',
            "L'invité à été supprimé"
        );

        return $this->redirectToRoute('user_guest_invite');
    }

    /**
     * @Route("/invitation/jeux-invite/",
     *     name="user_guest_game")
     * @Security("is_granted('ROLE_USER')")
     */
    public function gameGuestAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        if (!$user->hasGuest()) {
            return $this->redirectToRoute('user_guest_invite');
        }

        $invite = $user
            ->getInvite();


        $gameRepository = $em->getRepository("AdminBundle:Game");

        $games = null;
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

        return $this->render('ParticipantBundle:Guest:game.html.twig', array(
            "games" => $games,
            "research" => $research->createView(),
            "invite" => $invite
        ));
    }

    /**
     * @Route("/invitation/ajouter-jeux/{game}",
     *     name="user_guest_add_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function addGameGuestAction(Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $invite = $this
            ->getUser()
            ->getInvite();

        $invite->setGamesPlayed($game);
        $em->flush();

        $this->addFlash(
            'notice',
            'le jeu à été ajouté au jeu joué par votre invité');

        return $this->redirectToRoute('user_guest');

    }

    /**
     * @Route("/invitaton/enlever-jeux/{game}",
     *     name="user_guest_remove_game",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function deleteGameGuestAction(Game $game)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $invite = $this
            ->getUser()
            ->getInvite();

        $game->removeGuestsPlaying($invite);
        $invite->removeGamePlayed($game);
        $em->flush();

        $this->addFlash(
            'notice',
            'Le jeu à été enregistré pour votre invité'
        );

        return $this->redirectToRoute('user_guest');
    }
}