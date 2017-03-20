<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use UserBundle\Entity\User;

class testSwiftmailerOnCreateCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('own:test:swiftmailer')
            ->setDescription('Test de fonctionnement de switfmailer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('Creating user');
        $password = "gonzalez";
        $user = $this
            ->getContainer()
            ->get('fos_user.util.user_manipulator')
            ->create('pepito', $password, 'delahayest@gmail.com', 1, 0);

        $output->writeln('Sending mail');
        /*$message = \Swift_Message::newInstance()
            ->setSubject('site de la lan des sios')
            ->setFrom('lan2017@sio57.info')
            ->setTo($user->getEmail())
            ->setBody(
                $this->getContainer()->get('templating')->render('Emails/registration.html.twig', array('password'=>$password, 'username'=>$user->getUsername())),
                'text/html'
            );
        $this->getContainer()->get('mailer')->send($message);*/
        $output->writeln('All done ! :D');
    }


}
