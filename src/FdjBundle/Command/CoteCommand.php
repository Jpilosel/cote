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
        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
//        $em = $this->getDoctrine()->getManager();
        $em = $this->getContainer()->get('doctrine')->getManager();

        $api = file_get_contents('https://www.parionssport.fr/api/1n2/offre?sport=964500');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
        $jsonapi = json_decode($api, true);
        $nbMatch = count($jsonapi);
//        var_dump($nbMatch);

        foreach ($jsonapi as $jsonapi2) {
            $formulesBdd = $em->getRepository('FdjBundle:SportCote')->findByEventId($jsonapi2['eventId']);
            $nbFormulesBdd = count($formulesBdd);
//            var_dump($nbFormulesBdd);
//            var_dump($jsonapi2);
            $doublon=0;
            for ($a=0; $a<$nbFormulesBdd; $a++){
                if ( $formulesBdd[$a]->getMarketId()== $jsonapi2['marketId'] ) {
                    $doublon = 1;
                }
            }
            if (isset($jsonapi2['marketId']) && $doublon == 0) {
                $sportCote = new Sportcote();
                //            var_dump($sportCote);
                //var_dump($jsonapi2['formules'][6]);
                $sportCote->setEventId($jsonapi2['eventId']);
                $sportCote->setMarketId($jsonapi2['marketId']);
                $sportCote->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                $sportCote->setSportId($jsonapi2['sportId']);
                $sportCote->setIndexP($jsonapi2['index']);
                $sportCote->setMarketTypeGroup($jsonapi2['marketTypeGroup']);
                $sportCote->setMarketType($jsonapi2['marketType']);
                $sportCote->setMarketTypeId($jsonapi2['marketTypeId']);
                $sportCote->setEnd($jsonapi2['end']);
                $sportCote->setLabel($jsonapi2['label']);
                $sportCote->setEventType($jsonapi2['eventType']);
                $sportCote->setCompetition($jsonapi2['competition']);
                $sportCote->setCompetitionId($jsonapi2['competitionId']);
                $nbCoteAnexe = count($jsonapi2['outcomes']);
                if ($nbCoteAnexe == 2) {
                    $sportCote->setUn($jsonapi2['outcomes'][0]['cote']);
                    $sportCote->setDeux($jsonapi2['outcomes'][1]['cote']);
                } elseif ($nbCoteAnexe == 3) {
                    $sportCote->setUn($jsonapi2['outcomes'][0]['cote']);
                    $sportCote->setNul($jsonapi2['outcomes'][1]['cote']);
                    $sportCote->setDeux($jsonapi2['outcomes'][2]['cote']);
                }
                $em->persist($sportCote);
                var_dump($sportCote);
                $em->flush();
                $nbCoteAnexe = $jsonapi2['nbMarkets'];
//                var_dump($nbCoteAnexe);
//                var_dump($jsonapi2);
                for ($p = 0; $p < $jsonapi2['nbMarkets']; $p++) {

                    //                var_dump($jsonapi2['formules']);
//                    var_dump($p);
//                    var_dump($nbCoteAnexe);
                    $sportCote = new Sportcote();
                    $sportCote->setEventId($jsonapi2['formules'][$p]['eventId']);
                    $sportCote->setMarketId($jsonapi2['formules'][$p]['marketId']);
                    $sportCote->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                    $sportCote->setSportId($jsonapi2['formules'][$p]['sportId']);
                    $sportCote->setIndexP($jsonapi2['formules'][$p]['index']);
                    $sportCote->setMarketTypeGroup($jsonapi2['formules'][$p]['marketTypeGroup']);
                    $sportCote->setMarketType($jsonapi2['formules'][$p]['marketType']);
                    $sportCote->setMarketTypeId($jsonapi2['formules'][$p]['marketTypeId']);
                    $sportCote->setEnd($jsonapi2['formules'][$p]['end']);
                    $sportCote->setLabel($jsonapi2['formules'][$p]['label']);
                    $sportCote->setEventType($jsonapi2['eventType']);
                    $sportCote->setCompetition($jsonapi2['formules'][$p]['competition']);
                    $sportCote->setCompetitionId($jsonapi2['formules'][$p]['competitionId']);
                    $nbCoteAnexe = count($jsonapi2['outcomes']);
                    if ($nbCoteAnexe == 2) {
                        $sportCote->setUn($jsonapi2['formules'][$p]['outcomes'][0]['cote']);
                        $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                    } elseif ($nbCoteAnexe == 3) {
                        $sportCote->setUn($jsonapi2['formules'][$p]['outcomes'][0]['cote']);
                        $sportCote->setNul($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                        $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][2]['cote']);
                    }
                    var_dump($sportCote);
                    $em->persist($sportCote);

                    $em->flush();

                }
            }
        }
        $output->writeln(['============','cote fin',]);
    }
}