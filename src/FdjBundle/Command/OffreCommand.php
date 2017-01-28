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
        $output->writeln(['cote inputt','============',]);
//        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
//        $em = $this->getDoctrine()->getManager();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $api =file_get_contents('https://www.parionssport.fr/api/1n2/offre');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
        $jsonapi =  json_decode($api, true);
        $nbMatch = count($jsonapi);
//        var_dump($nbMatch);
        for ($i=0; $i<$nbMatch; $i++){
            $sportsBdd = $em->getRepository('FdjBundle:Sport')->findByEventId($jsonapi[$i]['eventId']);
            if ($sportsBdd == null || $jsonapi[$i]['eventId'] != ($sportsBdd[0]->getEventId())){
                $sport = new Sport();
                $sport->setEventId($jsonapi[$i]['eventId']);
                $sport->setMarketId($jsonapi[$i]['marketId']);
                $sport->setHasCombiBonus($jsonapi[$i]['hasCombiBonus']);
                $sport->setSportId($jsonapi[$i]['sportId']);
                $sport->setIndexP($jsonapi[$i]['index']);
                $sport->setMarketType($jsonapi[$i]['marketType']);
                $sport->setMarketTypeGroup($jsonapi[$i]['marketTypeGroup']);
                $sport->setMarketTypeId($jsonapi[$i]['marketTypeId']);
                $sport->setEnd($jsonapi[$i]['end']);
                $sport->setLabel($jsonapi[$i]['label']);
                $sport->setEventType($jsonapi[$i]['eventType']);
                $sport->setCompetition($jsonapi[$i]['competition']);
                $sport->setCompetitionId($jsonapi[$i]['competitionId']);
                $sport->setNbMarkets($jsonapi[$i]['nbMarkets']);
                $em->persist($sport);
                var_dump($sport);
                $em->flush();
            }
        }

        $output->writeln(['============','sport fin',]);
    }
}