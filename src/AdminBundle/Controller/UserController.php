<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\UserBundle\Event\GetResponseUserEvent;

class UserController extends Controller
{
    /**
     * @Route("/lister-utilisateurs/",
     * name="admin_list_user")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $UserRepository = $em->getRepository("UserBundle:User");
        $users = $UserRepository->findAllUserOrderByName();

        return $this->render('AdminBundle:Default:index.html.twig', array(
            "users" => $users
        ));
    }

    /**
     * @Route("/ajouter-utilisateur/",
     *     name="admin_add_user")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addUserAction(Request $request)
    {
        $successMessage = null;
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $form = $this->createForm(new UserType(), $user);
        $event = new GetResponseUserEvent($user, $request);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $successMessage = "l'utilisateur ". $user->getUsername() ." à bien été rajouté";
                $userManager->updateUser($user);
            }

        }

        return $this->render('AdminBundle:User:add.html.twig', array(
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ));
    }
}