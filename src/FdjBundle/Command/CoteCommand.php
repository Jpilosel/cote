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
use FdjBundle\Entity\Cote;

class CoteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:cote')
            ->setDescription('Reception des matchs avec la cote.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt','============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $matchfinis = $em->getRepository('FdjBundle:MatchFini')->findByMatchFini(null);
        var_dump(count($matchfinis));
        foreach ($matchfinis as $matchfini) {
            $coteGagnante = $cotePerdante1 = $cotePerdante2 = null;
//            var_dump($matchfini);
//            $sports = $matchfini->getSportId();
//            $cotesSports = $em->getRepository('FdjBundle:Cote')->findBySportId($sports);
            if ($matchfini->getResultat() == 1 ){
                $coteGagnante = $matchfini->getUn();
                $cotePerdante1 = $matchfini->getNul();
                $cotePerdante2 = $matchfini->getDeux();
            }elseif ($matchfini->getResultat() == 'N' ){
                $cotePerdante1 = $matchfini->getUn();
                $coteGagnante = $matchfini->getNul();
                $cotePerdante2 = $matchfini->getDeux();
            }elseif ($matchfini->getResultat() == 2){
                $cotePerdante1 = $matchfini->getUn();
                $cotePerdante2= $matchfini->getNul();
                $coteGagnante = $matchfini->getDeux();
            }
            var_dump($coteGagnante);
            $set = 0;
            if ($coteGagnante) {
                $cotes = $em->getRepository('FdjBundle:Cote')->findByCote($coteGagnante);
                if (!$cotes) {
                    $cote = new Cote();
                    $cote->setSportId($matchfini->getSportId());
                    $cote->setCompetition($matchfini->getCompetition());
                    $cote->setCompetitionId($matchfini->getCompetitionId());
                    $cote->setMarketType($matchfini->getMarketType());
                    $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $cote->setResultat($matchfini->getResultat());
                    $cote->setCote($coteGagnante);
                    $cote->setStatut('g');
                    $cote->setRecurrence(1);
                    var_dump($cote);
                    $em->persist($cote);
                    $em->flush();
                } else {
                    $set = 0;
                    var_dump($matchfini);
                    foreach ($cotes as $cote) {
                        var_dump($cote);
                        if ($set==0){
                            if ($cote->getSportId() == $matchfini->getSportId() && $cote->getStatut() == 'g' && $cote->getCompetitionId() == $matchfini->getCompetitionId() && $cote->getMarketTypeGroup() == $matchfini->getMarketTypeGroup()) {
                                $recurrence = $cote->getRecurrence() + 1;
                                $cote->setRecurrence($recurrence);
                                $recurrence = null;
                                var_dump($cote);
                                $em->persist($cote);
                                $em->flush();
                                $set = 1;
                            }
                        }elseif ($set==0){
                            $cote = new Cote();
                            $cote->setSportId($matchfini->getSportId());
                            $cote->setCompetition($matchfini->getCompetition());
                            $cote->setCompetitionId($matchfini->getCompetitionId());
                            $cote->setMarketType($matchfini->getMarketType());
                            $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                            $cote->setResultat($matchfini->getResultat());
                            $cote->setCote($coteGagnante);
                            $cote->setStatut('g');
                            $cote->setRecurrence(1);
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        }
                        var_dump($set);
                    }
                }
            }


            $set = 0;
            if ($cotePerdante1) {
                $cotes = $em->getRepository('FdjBundle:Cote')->findByCote($cotePerdante1);
                if (!$cotes){
                    $cote = new Cote();
                    $cote->setSportId($matchfini->getSportId());
                    $cote->setCompetition($matchfini->getCompetition());
                    $cote->setCompetitionId($matchfini->getCompetitionId());
                    $cote->setMarketType($matchfini->getMarketType());
                    $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $cote->setResultat($matchfini->getResultat());
                    $cote->setCote($cotePerdante1);
                    $cote->setStatut('p');
                    $cote->setRecurrence(1);
                    var_dump($cote);
                    $em->persist($cote);
                    $em->flush();
                }else {
                    $set = 0;
                    if ($set==0){
                        foreach ($cotes as $cote) {
                            if ( $cote->getSportId() == $matchfini->getSportId() && $cote->getStatut() == 'p' && $cote->getCompetitionId() == $matchfini->getCompetitionId() && $cote->getMarketTypeGroup() == $matchfini->getMarketTypeGroup()) {
                                $recurrence = $cote->getRecurrence() + 1;
                                $cote->setRecurrence($recurrence);
                                $recurrence = null;
                                var_dump($cote);
                                $em->persist($cote);
                                $em->flush();
                                $set = 1;
                            }
                        }
                    }elseif ($set==0){
                        $cote = new Cote();
                        $cote->setSportId($matchfini->getSportId());
                        $cote->setCompetition($matchfini->getCompetition());
                        $cote->setCompetitionId($matchfini->getCompetitionId());
                        $cote->setMarketType($matchfini->getMarketType());
                        $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                        $cote->setResultat($matchfini->getResultat());
                        $cote->setCote($cotePerdante1);
                        $cote->setStatut('p');
                        $cote->setRecurrence(1);
                        var_dump($cote);
                        $em->persist($cote);
                        $em->flush();
                    }
                }
            }
            if ($cotePerdante2) {
                $cotes = $em->getRepository('FdjBundle:Cote')->findByCote($cotePerdante2);
                if (!$cotes){
                    $cote = new Cote();
                    $cote->setSportId($matchfini->getSportId());
                    $cote->setCompetition($matchfini->getCompetition());
                    $cote->setCompetitionId($matchfini->getCompetitionId());
                    $cote->setMarketType($matchfini->getMarketType());
                    $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $cote->setResultat($matchfini->getResultat());
                    $cote->setCote($cotePerdante2);
                    $cote->setStatut('p');
                    $cote->setRecurrence(1);
                    var_dump($cote);
                    $em->persist($cote);
                    $em->flush();
                }else {
                    $set = 0;
                    if ($set==0){
                        foreach ($cotes as $cote) {
                            if ( $cote->getSportId() == $matchfini->getSportId() && $cote->getStatut() == 'p' && $cote->getCompetitionId() == $matchfini->getCompetitionId() && $cote->getMarketTypeGroup() == $matchfini->getMarketTypeGroup()) {
                                $recurrence = $cote->getRecurrence() + 1;
                                $cote->setRecurrence($recurrence);
                                $recurrence = null;
                                var_dump($cote);
                                $em->persist($cote);
                                $em->flush();
                                $set = 1;
                            }
                        }
                    }elseif ($set==0){
                        $cote = new Cote();
                        $cote->setSportId($matchfini->getSportId());
                        $cote->setCompetition($matchfini->getCompetition());
                        $cote->setCompetitionId($matchfini->getCompetitionId());
                        $cote->setMarketType($matchfini->getMarketType());
                        $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                        $cote->setResultat($matchfini->getResultat());
                        $cote->setCote($cotePerdante2);
                        $cote->setStatut('p');
                        $cote->setRecurrence(1);
                        var_dump($cote);
                        $em->persist($cote);
                        $em->flush();
                    }
                }
            }
        }
        $output->writeln(['============','cote fin',]);
    }
}