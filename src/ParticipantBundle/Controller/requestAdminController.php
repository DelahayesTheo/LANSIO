<?php

namespace ParticipantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
class requestAdminController extends Controller
{
    /**
     * @Route('/demande-admin/',
     *      name="user_request_admin")
     * @Security("is_granted('ROLE_USER')")
     */
    public function requestAdminAction()
    {

    }

    /**
     * @Route('/ajouter-demande-admin/',
     *      name="user_add_request")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addRequestAdminAction()
    {

    }
}