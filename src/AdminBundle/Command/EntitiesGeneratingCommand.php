<?php
namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AdminBundle\Entity\EquipmentType;

class EntitiesGeneratingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('entities:generate')
            ->setDescription('Generate entities for the backend')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $output->writeln("Generating Equipment Types ...");
        $this->addEquipmentTypes($em);
        $em->flush();
    }

    private function addEquipmentTypes($em)
    {
        $em->persist($this->newEquipmentType("Manette filiaire"));
        $em->persist($this->newEquipmentType("Kinect"));
        $em->persist($this->newEquipmentType("Gamepad"));
        $em->persist($this->newEquipmentType("Oculus Rift"));
        $em->persist($this->newEquipmentType("Wiimote"));
        $em->persist($this->newEquipmentType("Nunchuk"));
        $em->persist($this->newEquipmentType("Adaptateur GameCube"));
        $em->persist($this->newEquipmentType("Manette sans fil"));
        $em->persist($this->newEquipmentType("Wii balance board"));
        $em->persist($this->newEquipmentType("HTC Vive"));
        $em->persist($this->newEquipmentType("Playstation VR"));
        $em->persist($this->newEquipmentType("Chargeur"));
        $em->persist($this->newEquipmentType("Console"));
        $em->persist($this->newEquipmentType("Playstation Move"));
        $em->persist($this->newEquipmentType("Casque"));
        $em->persist($this->newEquipmentType("Adaptateur Secteur"));
        $em->persist($this->newEquipmentType("HDMI"));

    }

    private function newEquipmentType($wording)
    {
        $equipmentType = new EquipmentType();
        $equipmentType->setWording($wording);
        return $equipmentType;
    }
}