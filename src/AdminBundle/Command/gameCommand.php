<?php
namespace AdminBundle\Command;

use AdminBundle\Entity\Equipment;
use AdminBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AdminBundle\Entity\EquipmentType;

class gameCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('generate:add:games')
            ->setDescription('Generate entities for the backend');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $output->writeln("Adding Game ...");
        $this->addEquipmentAndEquipmentTypes($em);

        //RELACHER LE KRAKEN
        $em->flush();
    }
}