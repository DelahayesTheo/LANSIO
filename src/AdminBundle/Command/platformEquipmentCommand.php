<?php
namespace AdminBundle\Command;

use AdminBundle\Entity\Equipment;
use AdminBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AdminBundle\Entity\EquipmentType;

class platformEquipmentCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('generate:platform:equipment')
            ->setDescription('Generate entities for the backend');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $output->writeln("Generating Equipment Types, Platforms and Equipments ...");
        $this->addEquipmentAndEquipmentTypes($em, $output);

        //RELACHER LE KRAKEN
        $em->flush();
    }

    private function addEquipmentAndEquipmentTypes($em, $output)
    {
        //Creer les plateformes
        $ps4 = $this->newPlatform("PS4", "Playstation 4");
        $xboxOne = $this->newPlatform("XBOXONE", "Xbox One");
        $wiiU = $this->newPlatform("WIIU", "Wii U");
        $wii = $this->newPlatform("WII", "Wii");
        $pc = $this->newPlatform("PC", "Ordinateur");
        $xbox360 = $this->newPlatform("XBOX360", "Xbox 360");
        $ps3 = $this->newPlatform("PS3", "Playstation 3");
        $multi = $this->newPlatform("MULTI", "Multi plateforme");

        //Creer les types d'équipements
        $manetteFiliaire = $this->newEquipmentType("Manette filiaire");
        $kinect = $this->newEquipmentType("Kinect");
        $gamepad = $this->newEquipmentType("Gamepad");
        $oculus = $this->newEquipmentType("Oculus Rift");
        $wiimote = $this->newEquipmentType("Wiimote");
        $wiimoteMP = $this->newEquipmentType("Wiimote Motion Plus");
        $nunchuk = $this->newEquipmentType("Nunchuk");
        $adaptateurGameCube = $this->newEquipmentType("Adaptateur GameCube");
        $manetteSansFil = $this->newEquipmentType("Manette sans fil");
        $wiiBalanceBoard = $this->newEquipmentType("Wii balance board");
        $htcVive = $this->newEquipmentType("HTC Vive");
        $playstationVR = $this->newEquipmentType("Playstation VR");
        $chargeur = $this->newEquipmentType("Chargeur");
        $console = $this->newEquipmentType("Console");
        $playstationMove = $this->newEquipmentType("Playstation Move");
        $casque = $this->newEquipmentType("Casque");
        $adaptateurSecteur = $this->newEquipmentType("Adaptateur Secteur");
        $HDMI = $this->newEquipmentType("HDMI");

        $output->writeln("Generating Platforms");
        //Preparer les plateformes à l'insertion dans la base de données
        $em->persist($ps4);
        $em->persist($xboxOne);
        $em->persist($wiiU);
        $em->persist($wii);
        $em->persist($pc);
        $em->persist($xbox360);
        $em->persist($ps3);
        $em->persist($multi);

        $output->writeln("Generating Equipment Types");
        //Prepare les type d'équipement à l'insertion dans la base de données
        $em->persist($manetteFiliaire);
        $em->persist($kinect);
        $em->persist($gamepad);
        $em->persist($oculus);
        $em->persist($wiimote);
        $em->persist($wiimoteMP);
        $em->persist($nunchuk);
        $em->persist($adaptateurGameCube);
        $em->persist($manetteSansFil);
        $em->persist($wiiBalanceBoard);
        $em->persist($htcVive);
        $em->persist($playstationVR);
        $em->persist($chargeur);
        $em->persist($console);
        $em->persist($playstationMove);
        $em->persist($casque);
        $em->persist($adaptateurSecteur);
        $em->persist($HDMI);

        $output->writeln("Generating Equipment");
        //Prepare les equipements à l'insertion dans la base de données
        $em->persist($this->newEquipment($multi, $HDMI));

        $em->persist($this->newEquipment($ps4, $adaptateurSecteur));
        $em->persist($this->newEquipment($xboxOne, $adaptateurSecteur));
        $em->persist($this->newEquipment($xbox360, $adaptateurSecteur));
        $em->persist($this->newEquipment($ps3, $adaptateurSecteur));
        $em->persist($this->newEquipment($pc, $adaptateurSecteur));
        $em->persist($this->newEquipment($wii, $adaptateurSecteur));
        $em->persist($this->newEquipment($wiiU, $adaptateurSecteur));

        $em->persist($this->newEquipment($ps4, $casque));
        $em->persist($this->newEquipment($xboxOne, $casque));
        $em->persist($this->newEquipment($xbox360, $casque));
        $em->persist($this->newEquipment($ps3, $casque));
        $em->persist($this->newEquipment($pc, $casque));
        $em->persist($this->newEquipment($wii, $casque));
        $em->persist($this->newEquipment($wiiU, $casque));
        $em->persist($this->newEquipment($multi, $casque));

        $em->persist($this->newEquipment($ps4, $console));
        $em->persist($this->newEquipment($xboxOne, $console));
        $em->persist($this->newEquipment($xbox360, $console));
        $em->persist($this->newEquipment($ps3, $console));
        $em->persist($this->newEquipment($pc, $console));
        $em->persist($this->newEquipment($wii, $console));
        $em->persist($this->newEquipment($wiiU, $console));

        $em->persist($this->newEquipment($ps4, $manetteFiliaire));
        $em->persist($this->newEquipment($xboxOne, $manetteFiliaire));
        $em->persist($this->newEquipment($xbox360, $manetteFiliaire));
        $em->persist($this->newEquipment($ps3, $manetteFiliaire));
        $em->persist($this->newEquipment($pc, $manetteFiliaire));
        $em->persist($this->newEquipment($wii, $manetteFiliaire));
        $em->persist($this->newEquipment($wiiU, $manetteFiliaire));

        $em->persist($this->newEquipment($ps4, $manetteSansFil));
        $em->persist($this->newEquipment($xboxOne, $manetteSansFil));
        $em->persist($this->newEquipment($xbox360, $manetteSansFil));
        $em->persist($this->newEquipment($ps3, $manetteSansFil));
        $em->persist($this->newEquipment($pc, $manetteSansFil));
        $em->persist($this->newEquipment($wii, $manetteSansFil));
        $em->persist($this->newEquipment($wiiU, $manetteSansFil));

        $em->persist($this->newEquipment($ps4, $playstationMove));
        $em->persist($this->newEquipment($xboxOne, $kinect));
        $em->persist($this->newEquipment($xbox360, $kinect));

        $em->persist($this->newEquipment($wiiU, $gamepad));
        $em->persist($this->newEquipment($wiiU, $adaptateurGameCube));

        $em->persist($this->newEquipment($wii, $wiimoteMP));
        $em->persist($this->newEquipment($wii, $wiimote));
        $em->persist($this->newEquipment($wii, $nunchuk));
        $em->persist($this->newEquipment($wii, $wiiBalanceBoard));

        $em->persist($this->newEquipment($multi, $oculus));
        $em->persist($this->newEquipment($pc, $htcVive));
        $em->persist($this->newEquipment($ps4, $playstationVR));

        $output->writeln("All Done ! :D");

    }

    private function newEquipmentType($wording)
    {
        $equipmentType = new EquipmentType();
        $equipmentType->setWording($wording);
        return $equipmentType;
    }

    private function newPlatform($code, $wording)
    {
        $platform = new Platform();
        $platform->setCode($code);
        $platform->setWording($wording);
        return $platform;
    }

    private function newEquipment($platform, $equipmentType)
    {
        $equipment = new Equipment();
        $equipment->setEquipmentType($equipmentType);
        $equipment->setPlatform($platform);
        return $equipment;
    }
}