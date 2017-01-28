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

class ResultatCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:offre')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
//        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
//        $em = $this->getDoctrine()->getManager();
        $em = $this->getContainer()->get('doctrine')->getManager();

        $api = file_get_contents('https://www.parionssport.fr/api/1n2/resultats');//9 resultat sans cote
        $jsonapi = json_decode($api, true);
        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
        foreach ($jsonapi as $jsonapi2) {
            $nbParis = count($jsonapi2['marketRes']);
            for ($j = 0; $j < $nbParis; $j++) {
                $formulesBdd = $em->getRepository('FdjBundle:Formules')->findByEventId($jsonapi2['eventId']);
                $nbFormulesBdd = count($formulesBdd);
                $doublon = 0;
                for ($a = 0; $a < $nbFormulesBdd; $a++) {
                    if ($formulesBdd[$a]->getIndexP() == $jsonapi2['marketRes'][$j]['index']) {
                        $doublon = 1;
                    }
                }
//                var_dump($doublon);

                if (isset($jsonapi2['marketRes'][$j]['resultat']) && $doublon == 0) {
                    $nbResult = count($jsonapi2['marketRes'][$j]['resultat']);
                    for ($k = 1; $k <= $nbResult; $k++) {
                        if ($jsonapi2['marketRes'][$j]['resultat'][$k]['winner'] == 1) {
                            $formules = new Formules();
                            $formules->setEventId($jsonapi2['eventId']);
                            $formules->setLabel($jsonapi2['label']);
                            $formules->setCompetition($jsonapi2['competition']);
                            $formules->setSportId($jsonapi2['sportId']);
                            $formules->setCompetitionId($jsonapi2['competitionID']);
                            $formules->setIndexP($jsonapi2['marketRes'][$j]['index']);
                            $formules->setMarketType($jsonapi2['marketRes'][$j]['marketType']);
                            $formules->setMarketTypeGroup($jsonapi2['marketRes'][$j]['marketTypeGroup']);
                            $formules->setMarketTypeId($jsonapi2['marketRes'][$j]['marketTypeId']);
                            $formules->setResult($jsonapi2['marketRes'][$j]['resultat'][$k]['label']);
                        }
                        if (isset($formules)) {
                            var_dump($formules);
                            $em->persist($formules);
                            $em->flush();
                        }
                    }
                }
            }
        }
        $output->writeln(['============','resultat fin',]);
    }
}