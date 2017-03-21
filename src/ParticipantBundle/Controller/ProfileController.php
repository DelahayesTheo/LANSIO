<?php

namespace ParticipantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use ParticipantBundle\Form\Type\IsEatingType;

class ProfileController extends Controller
{
    /**
     * @Route("/profil", name="participant_profile")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $this->getUser();

        $form = $this->createForm(new IsEatingType(), $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre choix à été prix en compte'
            );
        }
        return $this->render('ParticipantBundle:Profile:profile.html.twig', array(
            "user" => $user,
            "form" => $form->createView()
        ));
    }
}
