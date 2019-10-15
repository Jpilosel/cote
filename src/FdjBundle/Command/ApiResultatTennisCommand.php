<?php

namespace FdjBundle\Command;

use FdjBundle\Entity\ApiResultatTennis;
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

class ApiResultatTennisCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:apiResultatTennis')
            ->setDescription('Reception des matchs avec les resultat via l\'api.')
            ->setHelp("Cette commande lance une requette pour recevoir les resultat de tennis");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $now = new \DateTime();
//        $now = new \DateTime('2019/10/10');
//        for ($i=1; $i<100; $i++){
            $now->modify('-1 day');
            $lien = 'https://api.sportradar.com/tennis-t2/fr/schedules/'.$now->format('Y-m-d').'/results.json?api_key=dysqrwevnpemdfvanjr4rwtc';
            var_dump($lien);
            $api = file_get_contents($lien);
            $matchs = json_decode($api, true);

            foreach ($matchs['results'] as $match){
                $doublon  = $em->getRepository('FdjBundle:ApiResultatTennis')->findOneByIdMatch($match['sport_event']['id']);
                if ($doublon == null){
                    $name = $match['sport_event']['tournament']['name'];
                    $name = explode(" ", $name);
                    $minName = $name[0];
                    if ($minName == "ATP" or $minName == "WTA"){
                        if ($match["sport_event_status"]["match_status"] == "ended" && $match['sport_event']['tournament']["type"]  == "singles"){
                            $apiResultatTennis = new ApiResultatTennis();
                            var_dump($match['sport_event']['tournament']['name']);
                            $apiResultatTennis->setIdMatch($match['sport_event']['id']);
                            $dateTxt = substr($match['sport_event']['scheduled'],0,-15);
                            $date = new \DateTime($dateTxt);
                            $apiResultatTennis->setDate($date);
                            $apiResultatTennis->setNomTournois($match['sport_event']['tournament']['name']);
                            $apiResultatTennis->setIdTournois($match['sport_event']['tournament']['id']);
                            $apiResultatTennis->setType($match['sport_event']['tournament']['type']);
                            $apiResultatTennis->setGenre($match['sport_event']['tournament']['gender']);
                            $apiResultatTennis->setManche($match['sport_event']['tournament_round']['name']);
                            $apiResultatTennis->setJoueur1Id($match['sport_event']['competitors'][0]["id"]);
                            $apiResultatTennis->setJoueur1Nom($match['sport_event']['competitors'][0]["name"]);
                            $apiResultatTennis->setJoueur1Nationalite($match['sport_event']['competitors'][0]["nationality"]);
                            $apiResultatTennis->setJoueur1BracketNumber($match['sport_event']['competitors'][0]["bracket_number"]);
                            $apiResultatTennis->setJoueur1Qualifier($match['sport_event']['competitors'][0]["qualifier"]);
                            $apiResultatTennis->setJoueur2Id($match['sport_event']['competitors'][1]["id"]);
                            $apiResultatTennis->setJoueur2Nom($match['sport_event']['competitors'][1]["name"]);
                            $apiResultatTennis->setJoueur2Nationalite($match['sport_event']['competitors'][1]["nationality"]);
                            $apiResultatTennis->setJoueur2BracketNumber($match['sport_event']['competitors'][1]["bracket_number"]);
                            $apiResultatTennis->setJoueur2Qualifier($match['sport_event']['competitors'][1]["qualifier"]);
                            $apiResultatTennis->setIdGagnant($match['sport_event_status']['winner_id']);
                            $apiResultatTennis->setResultatMatchJ1($match['sport_event_status']['home_score']);
                            $apiResultatTennis->setResultatMatchJ2($match['sport_event_status']['away_score']);
                            foreach ($match['sport_event_status']['period_scores'] as $score){
                                if ($score["number"] == 1){
                                    $apiResultatTennis->setScoreS1J1($score["home_score"]);
                                    $apiResultatTennis->setScoreS1J2($score["away_score"]);
                                }elseif ($score["number"] == 2){
                                    $apiResultatTennis->setScoreS2J1($score["home_score"]);
                                    $apiResultatTennis->setScoreS2J2($score["away_score"]);
                                }elseif ($score["number"] == 3){
                                    $apiResultatTennis->setScoreS3J1($score["home_score"]);
                                    $apiResultatTennis->setScoreS3J2($score["away_score"]);
                                }elseif ($score["number"] == 4){
                                    $apiResultatTennis->setScoreS4J1($score["home_score"]);
                                    $apiResultatTennis->setScoreS4J2($score["away_score"]);
                                }elseif ($score["number"] == 5){
                                    $apiResultatTennis->setScoreS5J1($score["home_score"]);
                                    $apiResultatTennis->setScoreS5J2($score["away_score"]);
                                }
                            }
                            $em->persist($apiResultatTennis);
                            $em->flush();
                        }
                    }
                }
            }
//        }

        $output->writeln(['============','resultat fin',]);
    }
}