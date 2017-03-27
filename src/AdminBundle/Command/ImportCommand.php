<?php

namespace AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use UserBundle\Entity\User;

class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('import:csv')
            ->setDescription('Import users from CSV file')
            ->addArgument('csvPath', InputArgument::REQUIRED, 'Quel fichier CSV vas être utilisé ? (a mettre dans web/component)')
            ->addArgument('action', InputArgument::OPTIONAL, 'Que voulez vous faire ? \n 1.Créer des utilisateurs \n 2.Envoyer un email de rappel');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $action = $input->getArgument('action');

        if (!$action || $action == 1) {
            // Showing when the script is launched
            $now = new \DateTime();
            $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

            // Importing CSV on DB via Doctrine ORM
            $this->import($input, $output);

            // Showing when the script is over
            $now = new \DateTime();
            $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
        } else if ($action == 2) {
            $now = new \DateTime();
            $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
            $this->mail($input, $output);

            $now = new \DateTime();
            $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
        }

    }

    protected function mail(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 20;
        $i = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach ($data as $row) {
            $message = \Swift_Message::newInstance()
                ->setSubject('site de la lan des sios : rappel')
                ->setFrom('lan2017@sio57.info')
                ->setTo($row['email'])
                ->setBody(
                    $this->getContainer()->get('templating')->render('Emails/reminder.html.twig', array('firstName' => $row['firstname'], 'lastName' => $row['lastname'])),
                    'text/html'
                );
            $this->getContainer()->get('mailer')->send($message);

            if (($i % $batchSize) === 0) {
                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of users mailed ... | ' . $now->format('d-m-Y G:i:s'));

            }
            $i++;
        }
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 20;
        $i = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach ($data as $row) {
            $username = strtolower(str_replace(" ", "", $row['lastname']) . '.' . str_replace(" ", "", $row['firstname']));
            $bytes = openssl_random_pseudo_bytes(4);
            $pwd = bin2hex($bytes);
            $user = $this
                ->getContainer()
                ->get('fos_user.util.user_manipulator')
                ->create($username, $pwd, $row['email'], 1, 0);

            $user = $em
                ->getRepository('UserBundle:User')
                ->findOneBy(array('username' => $username));

            $user->setCohort($row['cohort']);

            $message = \Swift_Message::newInstance()
                ->setSubject('site de la lan des sios : relance')
                ->setFrom('lan2017@sio57.info')
                ->setTo($row['email'])
                ->setBody(
                    $this->getContainer()->get('templating')->render('Emails/registration.html.twig', array('password' => $pwd, 'username' => $username)),
                    'text/html'
                );
            $this->getContainer()->get('mailer')->send($message);

            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of users imported ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output)
    {
        // Getting the CSV from filesystem
        $csvPath = $input->getArgument('csvPath');
        $fileName = 'web/component/' . $csvPath;

        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('import.csvtoarray');
        $data = $converter->convert($fileName, ';');

        return $data;
    }

}
