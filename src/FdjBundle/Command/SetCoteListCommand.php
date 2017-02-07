<?php

namespace FdjBundle\Command;

use FdjBundle\Entity\CoteList;
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

class SetCoteListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:coteList')
            ->setDescription('Reception des matchs avec la cote.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt','============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $matchfinis = $em->getRepository('FdjBundle:MatchFini')->findByMatchFini(1);
        var_dump(count($matchfinis));
        foreach ($matchfinis as $matchfini) {
            $label = $matchfini->getLabel();
            $tab = explode("-", $label);
//            var_dump($tab);
            $equipe1 = $tab[0];
            $equipe2 = $tab[1];
            if ($matchfini->getResultat() == 1 || $matchfini->getResultat() == 'Equipe 1' || $matchfini->getResultat() == $equipe1 || $matchfini->getResultat() == '1/N' ){
                $coteList = new CoteList();
                $coteList->setEventId($matchfini->getEventId());
                $coteList->setMarketId($matchfini->getMarketId());
                $coteList->setSportId($matchfini->getSportId());
                $coteList->setIndexP($matchfini->getIndexP());
                $coteList->setMarketType($matchfini->getMarketType());
                $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                $coteList->setEnd($matchfini->getEnd());
                $coteList->setLabel($matchfini->getLabel());
                $coteList->setEventType($matchfini->getEventType());
                $coteList->setCompetition($matchfini->getCompetition());
                $coteList->setCompetitionId($matchfini->getCompetitionId());
                $coteList->setCote($matchfini->getUn());
                $coteList->setResultat('g');
                $coteList->setStatut(1);
                $em->persist($coteList);

                if($matchfini->getNul()) {
                    $coteList = new CoteList();
                    $coteList->setEventId($matchfini->getEventId());
                    $coteList->setMarketId($matchfini->getMarketId());
                    $coteList->setSportId($matchfini->getSportId());
                    $coteList->setIndexP($matchfini->getIndexP());
                    $coteList->setMarketType($matchfini->getMarketType());
                    $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                    $coteList->setEnd($matchfini->getEnd());
                    $coteList->setLabel($matchfini->getLabel());
                    $coteList->setEventType($matchfini->getEventType());
                    $coteList->setCompetition($matchfini->getCompetition());
                    $coteList->setCompetitionId($matchfini->getCompetitionId());
                    $coteList->setCote($matchfini->getNul());
                    $coteList->setResultat('p');
                    $coteList->setStatut(1);
                    $em->persist($coteList);
                }

                $coteList = new CoteList();
                $coteList->setEventId($matchfini->getEventId());
                $coteList->setMarketId($matchfini->getMarketId());
                $coteList->setSportId($matchfini->getSportId());
                $coteList->setIndexP($matchfini->getIndexP());
                $coteList->setMarketType($matchfini->getMarketType());
                $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                $coteList->setEnd($matchfini->getEnd());
                $coteList->setLabel($matchfini->getLabel());
                $coteList->setEventType($matchfini->getEventType());
                $coteList->setCompetition($matchfini->getCompetition());
                $coteList->setCompetitionId($matchfini->getCompetitionId());
                $coteList->setCote($matchfini->getDeux());
                $coteList->setResultat('p');
                $coteList->setStatut(1);
                $em->persist($coteList);
                $matchfini->setMatchFini(6);
                $em->persist($matchfini);
                $em->flush();
            }elseif ($matchfini->getResultat() == 'N' || $matchfini->getResultat() == 'N/2' ){
                $coteList = new CoteList();
                $coteList->setEventId($matchfini->getEventId());
                $coteList->setMarketId($matchfini->getMarketId());
                $coteList->setSportId($matchfini->getSportId());
                $coteList->setIndexP($matchfini->getIndexP());
                $coteList->setMarketType($matchfini->getMarketType());
                $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                $coteList->setEnd($matchfini->getEnd());
                $coteList->setLabel($matchfini->getLabel());
                $coteList->setEventType($matchfini->getEventType());
                $coteList->setCompetition($matchfini->getCompetition());
                $coteList->setCompetitionId($matchfini->getCompetitionId());
                $coteList->setCote($matchfini->getUn());
                $coteList->setResultat('p');
                $coteList->setStatut(1);
                $em->persist($coteList);

                if($matchfini->getNul()) {
                    $coteList = new CoteList();
                    $coteList->setEventId($matchfini->getEventId());
                    $coteList->setMarketId($matchfini->getMarketId());
                    $coteList->setSportId($matchfini->getSportId());
                    $coteList->setIndexP($matchfini->getIndexP());
                    $coteList->setMarketType($matchfini->getMarketType());
                    $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                    $coteList->setEnd($matchfini->getEnd());
                    $coteList->setLabel($matchfini->getLabel());
                    $coteList->setEventType($matchfini->getEventType());
                    $coteList->setCompetition($matchfini->getCompetition());
                    $coteList->setCompetitionId($matchfini->getCompetitionId());
                    $coteList->setCote($matchfini->getNul());
                    $coteList->setResultat('g');
                    $coteList->setStatut(1);
                    $em->persist($coteList);
                }

                $coteList = new CoteList();
                $coteList->setEventId($matchfini->getEventId());
                $coteList->setMarketId($matchfini->getMarketId());
                $coteList->setSportId($matchfini->getSportId());
                $coteList->setIndexP($matchfini->getIndexP());
                $coteList->setMarketType($matchfini->getMarketType());
                $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                $coteList->setEnd($matchfini->getEnd());
                $coteList->setLabel($matchfini->getLabel());
                $coteList->setEventType($matchfini->getEventType());
                $coteList->setCompetition($matchfini->getCompetition());
                $coteList->setCompetitionId($matchfini->getCompetitionId());
                $coteList->setCote($matchfini->getDeux());
                $coteList->setResultat('p');
                $coteList->setStatut(1);
                $em->persist($coteList);
                $matchfini->setMatchFini(7);
                $em->persist($matchfini);
                $em->flush();
            }elseif ($matchfini->getResultat() == 2 || $matchfini->getResultat() == 'Equipe 2' || $matchfini->getResultat() == $equipe2 || $matchfini->getResultat() == '1/2'){
                $coteList = new CoteList();
                $coteList->setEventId($matchfini->getEventId());
                $coteList->setMarketId($matchfini->getMarketId());
                $coteList->setSportId($matchfini->getSportId());
                $coteList->setIndexP($matchfini->getIndexP());
                $coteList->setMarketType($matchfini->getMarketType());
                $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                $coteList->setEnd($matchfini->getEnd());
                $coteList->setLabel($matchfini->getLabel());
                $coteList->setEventType($matchfini->getEventType());
                $coteList->setCompetition($matchfini->getCompetition());
                $coteList->setCompetitionId($matchfini->getCompetitionId());
                $coteList->setCote($matchfini->getUn());
                $coteList->setResultat('p');
                $coteList->setStatut(1);
                $em->persist($coteList);

                if($matchfini->getNul()) {
                    $coteList = new CoteList();
                    $coteList->setEventId($matchfini->getEventId());
                    $coteList->setMarketId($matchfini->getMarketId());
                    $coteList->setSportId($matchfini->getSportId());
                    $coteList->setIndexP($matchfini->getIndexP());
                    $coteList->setMarketType($matchfini->getMarketType());
                    $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                    $coteList->setEnd($matchfini->getEnd());
                    $coteList->setLabel($matchfini->getLabel());
                    $coteList->setEventType($matchfini->getEventType());
                    $coteList->setCompetition($matchfini->getCompetition());
                    $coteList->setCompetitionId($matchfini->getCompetitionId());
                    $coteList->setCote($matchfini->getNul());
                    $coteList->setResultat('p');
                    $coteList->setStatut(1);
                    $em->persist($coteList);
                }

                $coteList = new CoteList();
                $coteList->setEventId($matchfini->getEventId());
                $coteList->setMarketId($matchfini->getMarketId());
                $coteList->setSportId($matchfini->getSportId());
                $coteList->setIndexP($matchfini->getIndexP());
                $coteList->setMarketType($matchfini->getMarketType());
                $coteList->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                $coteList->setMarketTypeId($matchfini->getMarketTypeId());
                $coteList->setEnd($matchfini->getEnd());
                $coteList->setLabel($matchfini->getLabel());
                $coteList->setEventType($matchfini->getEventType());
                $coteList->setCompetition($matchfini->getCompetition());
                $coteList->setCompetitionId($matchfini->getCompetitionId());
                $coteList->setCote($matchfini->getDeux());
                $coteList->setResultat('g');
                $coteList->setStatut(1);
                $em->persist($coteList);
                $matchfini->setMatchFini(8);
                $em->persist($matchfini);
                $em->flush();
            }
        }
        $output->writeln(['============','cote fin',]);
    }
}