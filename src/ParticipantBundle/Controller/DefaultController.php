<?php

namespace ParticipantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ParticipantBundle\Form\Type\firstConnection;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="participant_dashboard")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        if (!$user->getHasDefinedRequired()) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            $form = $this->createForm(new firstConnection(), $user);

            if($form->handleRequest($request)->isValid()) {
                $verifUser = $em
                    ->getRepository('UserBundle:User')
                    ->findOneBy(array('username' => $user->getUsername()));

                if ($verifUser && $verifUser != $user) {
                    return $this->render('ParticipantBundle:Required:require_info.html.twig', array(
                        "form" => $form->createView(),
                        "message" => "Ce nom d'utilisateur est déjà pris"
                    ));
                }
                $user->setIsComing(true);
                $user->setHasDefinedRequired(true);
                $em->persist($user);
                $em->flush();
            } else {
                return $this->render('ParticipantBundle:Required:require_info.html.twig', array(
                    "form" => $form->createView(),
                    "message" => null
                ));
            }
        }
        return $this->render('ParticipantBundle:Default:index.html.twig', array(
            "user" => $user
        ));
    }

    /**
     * @Route("/en-cours-de-construction/",
     *     name="user_in_construction")
     * @Security("is_granted('ROLE_USER')")
     */
    public function inConstructionAction()
    {
        return $this->render('ParticipantBundle:Component:inConstruction.html.twig');
    }
}
