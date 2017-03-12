<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AdminBundle\Form\EquipmentType as EquipmentForm;
use AdminBundle\Entity\Equipment;
use AdminBundle\Entity\EquipmentType;
use AdminBundle\Form\EquipmentTypeType as EquipmentTypeForm;

class EquipmentController extends Controller
{
    /**
     * @Route("/ajouter-equipement/",
     *     name="admin_add_equipment")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addEquipmentAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $equipmentRepository = $em->getRepository('AdminBundle:Equipment');
        $equipments = $equipmentRepository->findAll();
        $equipment = new Equipment();
        $form = $this->createForm(new EquipmentForm(), $equipment);

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em->persist($equipment);
            $em->flush();
            $this->addFlash(
                "notice",
                "L équipement à été ajouté"
            );
            return $this->redirectToRoute("admin_add_equipment", array('request', null));
        }

        return $this->render("AdminBundle:Equipment:index.html.twig", array(
            "form" => $form->createView(),
            "equipments" => $equipments
        ));
    }

    /**
     * @Route("/ajouter-type-equipement/",
     *     name="admin_add_equipment_type")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addEquipmentTypeAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $equipmentTypeRepository = $em->getRepository('AdminBundle:EquipmentType');
        $equipmentTypes = $equipmentTypeRepository->findAll();
        $equipment = new EquipmentType();
        $form = $this->createForm(new EquipmentTypeForm(), $equipment);

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em->persist($equipment);
            $em->flush();
            $this->addFlash(
                "notice",
                "Le type d équipement à été ajouté"
            );
            return $this->redirectToRoute("admin_add_equipment_type", array('request', null));
        }

        return $this->render("AdminBundle:EquipmentType:index.html.twig", array(
            "form" => $form->createView(),
            "equipmentTypes" => $equipmentTypes
        ));
    }
}