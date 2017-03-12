<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\Equipment;
use ParticipantBundle\Entity\bringedEquipment;
use ParticipantBundle\Form\Type\bringedEquipmentType;
use UserBundle\Entity\User;
use ParticipantBundle\Form\Type\requireEquipmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class EquipmentController extends Controller
{
    /**
     * @Route("/equipement/",
     *     name="user_equipment")
     * @Security("is_granted('ROLE_USER')")
     */
    public function equipmentAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $user = $this
            ->getUser();
        $bringedEquipmentRepository = $em->getRepository('ParticipantBundle:bringedEquipment');
        $ownBringedEquipment = $bringedEquipmentRepository->findBy(array("user" => $user));
        $allBringedEquipment = $bringedEquipmentRepository->findAllbringedEquipmentSum();

        $form = $this->createForm(new requireEquipmentType(), $user);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'notice',
                'Les équipements que vous souhaitez emprunté ont été pris en compte'
            );
            return $this->redirectToRoute('user_equipment', array('request'=>null));
        }

        $bringedEquipment = new bringedEquipment();
        $formBringedEquipment = $this->createForm(new bringedEquipmentType(), $bringedEquipment);

        $formBringedEquipment->handleRequest($request);
        if($formBringedEquipment->isValid() && $formBringedEquipment->isSubmitted()) {
            $verif = $bringedEquipmentRepository->findOneBy(array('user' => $user, 'equipment' => $bringedEquipment->getEquipment()));

            if (empty($verif)) {
                $bringedEquipment->setUser($user);
                $em->persist($bringedEquipment);
                $em->flush();
                $this->addFlash(
                    'notice',
                    "L'équipement ramené est enregistré"
                );
            } else {
                $verif->setQuantity($verif->getQuantity() + $bringedEquipment->getQuantity());
                $em->persist($verif);
                $em->flush();
                $this->addFlash(
                    'notice',
                    "La quantité à été mise à jour"
                );
            }
            return $this->redirectToRoute('user_equipment', array('request'=>null));
        }
        return $this->render("ParticipantBundle:Equipment:index.html.twig", array(
            "form" => $form->createView(),
            "formBringedEquipment" => $formBringedEquipment->createView(),
            "ownBringedEquipment" => $ownBringedEquipment,
            "allBringedEquipment" => $allBringedEquipment
        ));
    }

    /**
     * @Route(name="user_equipement_add_bringed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addBringedEquipmentAction()
    {

    }
}