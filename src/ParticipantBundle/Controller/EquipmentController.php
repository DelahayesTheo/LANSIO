<?php

namespace ParticipantBundle\Controller;

use AdminBundle\Entity\Equipment;
use ParticipantBundle\Entity\bringedEquipment;
use ParticipantBundle\Form\Type\bringedEquipmentModifyType;
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
            if ($bringedEquipment->getQuantity() > 0) {
                if (empty($verif)) {
                    $bringedEquipment->setUser($user);
                    $bringedEquipment->setEquipment($bringedEquipment->getEquipment());
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
            } else {
                $this->addFlash(
                    'notice',
                    'Ramenez rien ou moins ?'
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
     * @Route("/modifier-equipement-apporte/{bringed}/",
     *     name="user_equipement_modify_bringed")
     * @Security("is_granted('ROLE_USER')")
     */
    public function modifyBringedEquipmentAction(BringedEquipment $bringed, Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $form = $this->createForm(new bringedEquipmentModifyType(), $bringed);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            if ($bringed->getQuantity() <= 0) {
                $em->remove($bringed);
                $em->flush();
            } else {
                $em->persist($bringed);
                $em->flush();
            }
            $this->addFlash(
                'notice',
                'Votre changement à été pris en compte'
            );
            return $this->redirectToRoute("user_equipment");
        }
        return $this->render("ParticipantBundle:Equipment:modify.html.twig", array(
            "form" => $form->createView(),
            "name" => $bringed->getEquipment()
        ));
    }

    /**
     * @Route("/supprimer-equipement-apporte/{bringed}/",
     *     name="user_equipment_delete_bringed",
     *     options={"expose"=true})
     * @Security("is_granted('ROLE_USER')")
     */
    public function deleteBringedEquipmentAction(BringedEquipment $bringed)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $em->remove($bringed);
        $em->flush();

        $this->addFlash(
            'notice',
            'L\'equipement à été supprimé de votre liste'
        );

        return $this->redirectToRoute("user_equipment");
    }
}