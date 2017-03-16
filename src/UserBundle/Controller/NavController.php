<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class NavController extends Controller
{
    /**
     * @Route(name="nav_controller")
     */
    public function navControllerAction($path)
    {
        $user = $this
            ->getUser();

        if ($path == "ADMIN") {
            return $this->render("AdminBundle:component:topNavbar.html.twig", array(
                "user" => $user
            ));
        } else if ($path == "USER") {
            return $this->render("ParticipantBundle:Component:topNavbar.html.twig", array(
                "user" => $user
            ));
        }

    }
}