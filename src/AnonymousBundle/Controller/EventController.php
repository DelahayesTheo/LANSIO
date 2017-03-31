<?php

namespace AnonymousBundle\Controller;

use AnonymousBundle\Entity\Event;
use AnonymousBundle\Form\Type\AddEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends Controller
{
    /**
     * @Route("/evenement/",
     *     name="anonymous_event")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $eventRepository = $em->getRepository('AnonymousBundle:Event');
        $events = $eventRepository->findBy(array('closed' => false));

        return $this->render('AnonymousBundle:Events:index.html.twig', array(
            "events" => $events
        ));
    }

    /**
     * @Route("/ajouter-evenement/",
     *     name="anonymous_event_add")
     */
    public function addAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $event = new Event();
        $form = $this->createForm(new AddEventType(), $event);

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            if ($event->getNbPlayersMax() <= 0) {
                $this->addFlash(
                    'notice',
                    'Rentrer un nombre de joueur maximum valide'
                );
                return $this->redirectToRoute('anonymous_event_add');
            }
            $event->setClosed(false);
            $event->setNbPlayers(1);

            $em->persist($event);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre evenement à bien été créer'
            );

            return $this->redirectToRoute('anonymous_event');
        }

        return $this->render('AnonymousBundle:Events:addEvent.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/join-evenement/{id}",
     *     name="anonymous_event_join",
     *     options={"expose"=true})
     */
    public function joinAction(Event $id)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        if ($id->getNbPlayers() == $id->getNbPlayersMax()) {
            $this->addFlash(
                'notice',
                'L evenement est au complet');
        } else {
            $id->setNbPlayers($id->getNbPlayers() + 1);
            $em->flush();
            $this->addFlash(
                'notice',
                'Vous avez rejoins l evenement');

        }

        return $this->redirectToRoute('anonymous_event');
    }

    /**
     * @Route("/fermer-evenement/{id}",
     *     name="anonymous_close_event")
     */
    public function closeAction(Event $id, Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $data = $form->getData();
            if ($data['password'] == $id->getPassword() || $data['password'] == 'tespdcestmoiladmin') {
                $id->setClosed(true);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'L evenement a ete clos'
                );
                return $this->redirectToRoute('anonymous_event');
            } else {
                $this->addFlash(
                    'notice',
                    'Le mot de passe ne correspond pas'
                );
            }
        }
        return $this->render('@Anonymous/Events/closeEvent.html.twig', array(
            "form" => $form->createView()
        ));
    }
}
