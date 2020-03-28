<?php

namespace FdjBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use FdjBundle\Entity\Formules;
use FdjBundle\Entity\Sport;
use FdjBundle\Entity\SportCote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class OffreCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:command')
            ->setDescription('Reception des matchs avec l offre.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
//        var_dump(file_get_contents('https://www.pointdevente.parionssport.fdj.fr/api/date/last-update'));
        $em = $this->getContainer()->get('doctrine')->getManager();
//        $sport = new Sport();
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/offre');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
        $api =file_get_contents('https://www.pointdevente.parionssport.fdj.fr/api/1n2/offre?');//meme resultat que la ligne précédente. pas testé
        $jsonapi =  json_decode($api, true);

        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
//        var_dump($jsonapi[0]);

        foreach ($jsonapi as $jsonapi2) {
//            var_dump($jsonapi2);
            $formulesBdd = $em->getRepository('FdjBundle:Sport')->findByMarketId($jsonapi2['marketId']);

            if(!$formulesBdd) {
//                if(($jsonapi2['marketTypeId']) == 4 || ($jsonapi2['marketTypeId']) == 40 || ($jsonapi2['marketTypeId']) == 23 || ($jsonapi2['marketTypeId']) == 5){
//                }else {
                    $sport = new sport();
                    $sport->setDateSasie(date("Y-m-d H:i:s"));
                    $sport->setEventId($jsonapi2['eventId']);
                    $sport->setMarketId($jsonapi2['marketId']);
                    $sport->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                    $sport->setSportId($jsonapi2['sportId']);
                    $sport->setIndexP($jsonapi2['index']);
                    $sport->setMarketTypeGroup($jsonapi2['marketTypeGroup']);
                    $sport->setMarketType($jsonapi2['marketType']);
                    $sport->setMarketTypeId($jsonapi2['marketTypeId']);
                    $sport->setEnd($jsonapi2['end']);
                    $sport->setLabel($jsonapi2['label']);
                    $sport->setEventType($jsonapi2['eventType']);
                    $sport->setCompetition($jsonapi2['competition']);
                    $sport->setCompetitionId($jsonapi2['competitionId']);
                    $sport->setOk(1);
                    $nbResultCote = count($jsonapi2['outcomes']);
                    if ($nbResultCote == 2) {
                        $sport->setUn($jsonapi2['outcomes'][0]['cote']);
                        $sport->setDeux($jsonapi2['outcomes'][1]['cote']);
                    } elseif ($nbResultCote == 3) {
                        $sport->setUn($jsonapi2['outcomes'][0]['cote']);
                        $sport->setNul($jsonapi2['outcomes'][1]['cote']);
                        $sport->setDeux($jsonapi2['outcomes'][2]['cote']);
                    }
                    $sport->setDateSasie(date("Y-m-d H:i:s"));
                    $em->persist($sport);
                    var_dump($sport);
                    $em->flush();
//                }
            }else{
                if ( $formulesBdd->getEnd() !=  $jsonapi2['end']){
                    $formulesBdd->setEnd($jsonapi2['end']);
                    $em->persist($formulesBdd);
                    $em->flush();
                }
            }
//            var_dump($jsonapi2['formules']);
            if ($jsonapi2['formules']) {
                foreach ($jsonapi2['formules'] as $jsonapi3) {
//                    var_dump($jsonapi3['marketId']);
                    $formulesBdd2 = $em->getRepository('FdjBundle:Sport')->findByMarketId($jsonapi3['marketId']);
                    if (!$formulesBdd2) {
//                        if(($jsonapi3['marketTypeId']) == 4 || ($jsonapi3['marketTypeId']) == 40 || ($jsonapi3['marketTypeId']) == 23 || ($jsonapi3['marketTypeId']) == 5){
//
//                        }else {
                            var_dump($formulesBdd2);
                            $sport = new sport();
                            $sport->setEventId($jsonapi3['eventId']);
                            $sport->setMarketId($jsonapi3['marketId']);
                            $sport->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                            $sport->setSportId($jsonapi3['sportId']);
                            $sport->setIndexP($jsonapi3['index']);
                            $sport->setMarketTypeGroup($jsonapi3['marketTypeGroup']);
                            $sport->setMarketType($jsonapi3['marketType']);
                            $sport->setMarketTypeId($jsonapi3['marketTypeId']);
                            $sport->setEnd($jsonapi3['end']);
                            $sport->setLabel($jsonapi3['label']);
                            $sport->setEventType($jsonapi2['eventType']);
                            $sport->setCompetition($jsonapi3['competition']);
                            $sport->setCompetitionId($jsonapi3['competitionId']);
                            $sport->setOk(1);
                            $nbResultCote = count($jsonapi3['outcomes']);
                            if ($nbResultCote == 2) {
                                $sport->setUn($jsonapi3['outcomes'][0]['cote']);
                                $sport->setDeux($jsonapi3['outcomes'][1]['cote']);
                            } elseif ($nbResultCote == 3) {
                                $sport->setUn($jsonapi3['outcomes'][0]['cote']);
                                $sport->setNul($jsonapi3['outcomes'][1]['cote']);
                                $sport->setDeux($jsonapi3['outcomes'][2]['cote']);
                            }
                            $sport->setDateSasie(date("Y-m-d H:i:s"));
                            $em->persist($sport);
                            var_dump($sport);
                            $em->flush();
                    }else{
                        if ( $formulesBdd2->getEnd() !=  $jsonapi3['end']){
                            $formulesBdd2->setEnd($jsonapi3['end']);
                            $em->persist($formulesBdd2);
                            $em->flush();
                        }
                    }
                }
            }
        }
        $output->writeln(['============','resultat fin',]);
    }
}