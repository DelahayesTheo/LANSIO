<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/",
     *     name="admin_dashboard")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $supportRequestRepository = $em->getRepository("AdminBundle:SupportRequest");
        $requestAdminGameRepository = $em->getRepository("ParticipantBundle:requestAdminGame");

        $nbSupportRequestNotDone = $supportRequestRepository->countSupportRequestNotDone();
        $nbRequestAdminNotDone = $requestAdminGameRepository->countRequestNotDone();

        return $this->render("AdminBundle:Default:dashboard.html.twig", array(
            "nbSupportRequest" => $nbSupportRequestNotDone,
            "nbRequestAdmin" => $nbRequestAdminNotDone
        ));
    }
}
