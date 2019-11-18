<?php

namespace FdjBundle\Command;

use FdjBundle\Entity\ClassementJoueurs;
use FdjBundle\Entity\TableCorrespondance;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use FdjBundle\Entity\MatchFini;
use FdjBundle\Entity\Formules;
use FdjBundle\Entity\Sport;
use FdjBundle\Entity\SportCote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiClassementJoueursCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:apiClassementJoueurs')
            ->setDescription('Reception des matchs avec les resultat via l\'api.')
            ->setHelp("Cette commande lance une requette pour recevoir les classements des joueurs");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
//        $var = $this->getParameter('api_pass');
//        dump($var);
//        die;

        $api = file_get_contents('https://api.sportradar.com/tennis-t2/en/players/rankings.json?api_key=sax69e9nbmdw8pcuuxucqn6j');
        $classementJoueurs = json_decode($api, true);
//        dump($classementJoueurs["rankings"]);
        $bdds  = $em->getRepository('FdjBundle:ClassementJoueurs')->findBySemaine($classementJoueurs["rankings"][0]['week']);
//        dump($bdds);
        $doublon = null;
        if ($bdds != null){
            foreach ($bdds as $bdd){
                if($bdd->getAnnee() == $classementJoueurs["rankings"][0]['year'] && $bdd->getSemaine() == $classementJoueurs["rankings"][0]['week']){
                    $doublon = 1;
                }
            }
        }
        dump($doublon);
        dump($classementJoueurs["rankings"][0]['week']);
//        dump($bdd->getSemaine());
        dump($classementJoueurs["rankings"][0]['year']);
//        dump($bdd->getAnnee());
        if($doublon == null){
            foreach ($classementJoueurs["rankings"] as $classementJoueur){
//            $classementJoueur['name'];
                dump($classementJoueur["name"]);
                foreach ($classementJoueur["player_rankings"] as $classement){
                    $joueur = new ClassementJoueurs();
                    $joueur->setType($classementJoueur["name"]);
                    $joueur->setAnnee($classementJoueur["year"]);
                    $joueur->setSemaine($classementJoueur["week"]);
                    $joueur->setIdJoueur($classement["player"]["id"]);
                    $joueur->setNomJoueurs($classement["player"]["name"]);
                    $joueur->setNom(explode(', ', $classement["player"]["name"])[0]);
                    $joueur->setPrenom(explode(', ', $classement["player"]["name"])[1]);
                    $joueur->setNationalite($classement["player"]["nationality"]);
                    $joueur->setRang($classement["rank"]);
                    $joueur->setPoints($classement["points"]);
                    $joueur->setRangMouvement($classement["ranking_movement"]);
                    $joueur->setTournoisJoue($classement["tournaments_played"]);
                    $em->persist($joueur);
                    $em->flush();
                    $correspondance  = $em->getRepository('FdjBundle:TableCorrespondance')->findOneBySportRadar($classement["player"]["name"]);
                    if ($correspondance == null){
                        $tableCorrespondance = new TableCorrespondance();
                        $tableCorrespondance->setSportRadar($classement["player"]["name"]);
                        $tableCorrespondance->setIdSportRadar($classement["player"]["id"]);
                        $em->persist($tableCorrespondance);
                        $em->flush();
                    }

                }
            }
        }
        $output->writeln(['============','resultat fin',]);
    }
}