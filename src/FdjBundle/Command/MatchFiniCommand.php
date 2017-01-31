<?php

namespace FdjBundle\Command;

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

class MatchFiniCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:matchFini')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();

        $resultats = $em->getRepository('FdjBundle:Formules')->findAll();

        foreach ($resultats as $resultat) {
            $eventId = $resultat->getEventId();
//var_dump($resultat);
            $matchs = $em->getRepository('FdjBundle:Sport')->findByEventId($eventId);
            if ($matchs) {

                $matchFini = new Matchfini();
//                var_dump($matchFini);
                foreach ($matchs as $match) {
                    $marketId = $match->getMarketId();
                    $matchsFinis = $em->getRepository('FdjBundle:MatchFini')->findByMarketId($marketId);
                    if ($matchsFinis){
//                    var_dump($matchsFinis);
                    }else {
//                    var_dump($resultat->getMarketType());
//                    var_dump($match->getMarketType());
//                    var_dump($match->getMarketTypeGroup());
                        if ($match->getMarketType() === $resultat->getMarketType() || $match->getMarketTypeGroup() === $resultat->getMarketType()) {
                            $matchFini->setEventId($match->getEventId());
                            $matchFini->setMarketId($match->getMarketId());
                            $matchFini->setHasCombiBonus($match->getHasCombiBonus());
                            $matchFini->setSportId($match->getSportId());
                            $matchFini->setIndexP($match->getIndexP());
                            $matchFini->setMarketType($match->getMarketType());
                            $matchFini->setMarketTypeGroup($match->getMarketTypeGroup());
                            $matchFini->setMarketTypeId($match->getmarketTypeId());
                            $matchFini->setEnd($match->getEnd());
                            $matchFini->setLabel($match->getLabel());
                            $matchFini->setEventType($match->getEventType());
                            $matchFini->setCompetition($match->getCompetition());
                            $matchFini->setCompetitionId($match->getCompetitionId());
                            $matchFini->setNbMarkets($match->getNbMarkets());
                            $matchFini->setUn($match->getUn());
                            $matchFini->setNul($match->getNul());
                            $matchFini->setDeux($match->getDeux());
                            $matchFini->setResultat($resultat->getResult());
                            var_dump($matchFini);
                            $em->persist($matchFini);
                            $em->flush();
                        }
                    }
                }
//                var_dump($resultat);
//                var_dump($match);
            }
        }
        $output->writeln(['============','resultat fin',]);
    }
}