<?php

namespace ParticipantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="participant_dashboard")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction()
    {
        return $this->render('ParticipantBundle:Default:index.html.twig');
    }
}
