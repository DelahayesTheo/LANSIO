<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\SupportRequest;
use AdminBundle\Form\SupportRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class SupportRequestController extends Controller
{
    /**
     * @Route("/support/",
     *     name="user_support_request")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $user = $this
            ->getUser();
        $supportRequest = new SupportRequest();
        $form = $this->createForm(new SupportRequestType(), $supportRequest);


        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $supportRequest->setUser($user);
            $supportRequest->setStatus(0);
            $em->persist($supportRequest);
            $em->flush();
            $this->addFlash(
                'notice',
                "Votre requête à été prise en compte"
            );
            return $this->redirectToRoute("user_support_request", array('request' => null));
        }
        return $this->render("ParticipantBundle:Support:index.html.twig", array(
            'form' => $form->createView()
        ));
    }
}