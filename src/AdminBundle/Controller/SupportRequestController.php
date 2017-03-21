<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AdminBundle\Entity\SupportRequest;
use UserBundle\Entity\User;

class SupportRequestController extends Controller
{
    /**
     * @Route("/support/",
     *     name="admin_support_request")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $supportRequestRepository = $em->getRepository("AdminBundle:SupportRequest");
        $requestInProgress = $supportRequestRepository->findBy(array('status' => 0));

        return $this->render('AdminBundle:Support:index.html.twig', array(
            "supportRequests" => $requestInProgress
        ));

    }

    /**
     * @Route("/fermer-requete/{support}",
     *     name="admin_close_request",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function closeRequestAction(SupportRequest $support)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $user = $support->getUser();
        $message = \Swift_Message::newInstance()
            ->setSubject('requete de support')
            ->setFrom('lan2017@sio57.info')
            ->setTo($user->getEmail())
            ->setBody(
                $this->get('templating')->render('Emails/supportRequestEmail.html.twig', array('supportRequest' => $support)),
                'text/html'
            );
        $this->get('mailer')->send($message);

        $support->setStatus(1);
        $em->persist($support);
        $em->flush();

        return $this->redirectToRoute("admin_support_request");
    }
}