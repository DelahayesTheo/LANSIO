<?php
namespace AdminBundle\Command;

use AdminBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class gameCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('generate:games')
            ->setDescription('Generate games for the backend');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $output->writeln("Adding Game ...");
        $this->addGames($em, $output);

        //RELACHER LE KRAKEN
        $em->flush();
    }

    private function addGames($em, $output)
    {
        $platformRepository = $em->getRepository("AdminBundle:Platform");

        $output->writeln("Searching for platforms");
        $ps4 = $platformRepository->findOneBy(array("wording" => "PS4"));
        $xboxOne = $platformRepository->findOneBy(array("wording" => "PS4"));
        $wiiU = $platformRepository->findOneBy(array("wording" => "WIIU"));
        $wii = $platformRepository->findOneBy(array("wording" => "WII"));
        $pc = $platformRepository->findOneBy(array("wording" => "PC"));
        $xbox360 = $platformRepository->findOneBy(array("wording" => "XBOX360"));
        $ps3 = $platformRepository->findOneBy(array("wording" => "PS3"));
        $multi = $platformRepository->findOneBy(array("wording" => "MULTI"));

        $output->writeln("Generating games");
        $em->persist($this->newGame("Overwatch", $multi, 12, "FPS"));
        $em->persist($this->newGame("Civilization V", $pc, 8, "Stratégie temps réel"));
        $em->persist($this->newGame("Civilization VI", $pc, 8, "Stratégie temps réel"));
        $em->persist($this->newGame("StarCraft II", $pc, 8, "Stratégie temsp réel"));
        $em->persist($this->newGame("Diablo III", $pc, 4, "Hack 'n' Slash"));
        $em->persist($this->newGame("Trine", $pc, 2, "Aventure Puzzle"));
        $em->persist($this->newGame("CS:GO", $pc, 10, "FPS"));
        $em->persist($this->newGame("CSS", $pc, 10, "FPS"));
        $em->persist($this->newGame("Trackmania", $pc, 99, "Course"));
        $em->persist($this->newGame("Team Fortress 2", $pc, 32, "FPS"));
        $em->persist($this->newGame("Minecraft", $pc, 99, "Sandbox"));
        $em->persist($this->newGame("Arma 3", $pc, 99, "Shooter Tactique"));
        $em->persist($this->newGame("PAYDAY 2", $multi, 4, "FPS"));
        $em->persist($this->newGame("Garry's Mod", $pc, 99, "Sandbox"));
        $em->persist($this->newGame("Brawlhalla", $multi, 4, "Combat Arène"));
        $em->persist($this->newGame("Tom Clancy's Ghost Recon : Wildlands", $multi, 4, "FPS"));
        $em->persist($this->newGame("Tom Clancy's Rainbow Six: Siege", $multi, 10, "FPS"));
        $em->persist($this->newGame("Street Fighter V", $multi, 2, "Combat"));
        $em->persist($this->newGame("League of Legends", $pc, 10, "Moba"));
        $em->persist($this->newGame("Naruto Shippuden Ultimate Ninja Storm 4", $pc, 2, "Combat"));
        $em->persist($this->newGame("Chivalry : Medieval Warfare", $pc, 99, "Hack 'n' Slash"));
        $em->persist($this->newGame("Dead Or Alive 5", $pc, 2, "Combat"));
        $em->persist($this->newGame("Fifa 17", $multi, 4, "Sport"));
        $em->persist($this->newGame("Elite Dangerous", $pc, 32, "Space Sim"));
        $em->persist($this->newGame("Rocket League", $multi, 6, "Sport"));
        $em->persist($this->newGame("GTA V", $multi, 99, "Action-Aventure"));
        $em->persist($this->newGame("H1Z1", $pc, 99, "Survival"));
        $em->persist($this->newGame("C&C Generals", $pc, 99, "Statégie temps réel"));
        $em->persist($this->newGame("BattleField 3", $multi, 64, "FPS"));
        $em->persist($this->newGame("BattleField 4", $multi, 64, "FPS"));
        $em->persist($this->newGame("BattleField 1", $multi, 64, "FPS"));
        $em->persist($this->newGame("For honor", $multi, 8, "Combat Arène"));
        $em->persist($this->newGame("Borderlands 2", $multi, 4, "FPS RPG"));
        $em->persist($this->newGame("Borderlands : the Pre Sequel", $multi, 4, "FPS RPG"));
        $em->persist($this->newGame("Rust", $pc, 99, "Survival"));
        $em->persist($this->newGame("AlienSwarm", $pc, 4, "TPS"));
        $em->persist($this->newGame("Evolve : stage 2", $pc, 5, "FPS"));
        $em->persist($this->newGame("No more room in hell", $pc, 4, "FPS"));
        $em->persist($this->newGame("Gurgamoth", $pc, 4, "Combat Arène"));
        $em->persist($this->newGame("Super Smash Bros", $wiiU, 8, "Combat Arène"));
        $em->persist($this->newGame("Mario Kart 8", $wiiU, 4, "Course"));
        $output->writeln("AllDone");
    }

    private function newGame($name, $platform, $nbMaxPlayer, $kind)
    {
        $game = new Game();
        $game->setName($name);
        $game->setPlatform($platform);
        $game->setNbMaxPlayer($nbMaxPlayer);
        $game->setKind($kind);
        return $game;
    }
}