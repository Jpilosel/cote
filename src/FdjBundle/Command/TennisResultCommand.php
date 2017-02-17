<?php

namespace FdjBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use FdjBundle\Entity\Formules;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FdjBundle\Entity\TennisScore;

class TennisResultCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:tennisResult')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
//
            $formules = $em->getRepository('FdjBundle:Formules')->findBySportId(600);

        foreach ($formules as $formule) {
            if($formule->getMarketTypeGroup() == 'Score exact' && $formule->getScoreTennis() == 1 ){

                $eventId = $formule->getEventId();
                $matchsFinis = $em->getRepository('FdjBundle:MatchFini')->findByEventId($eventId);
                foreach ($matchsFinis as $matchsFini) {

//                    var_dump($matchsFini);
                    if ($matchsFini->getMarketTypeId() == 1){
                        $tennisScore = new Tennisscore();
                        $cote1 = $matchsFini->getUn();
                        $cote2 = $matchsFini->getDeux();
                        $tennisScore->setUn($cote1);
                        $tennisScore->setDeux($cote2);
                        $tennisScore->setLabel($formule->getLabel());
                        $tennisScore->setEventId($formule->getEventId());
                        $tennisScore->setResultat($formule->getResult());
                        $tennisScore->setCompetition($formule->getCompetition());
                        $tennisScore->setCompetitionId($formule->getCompetitionId());
                        $tennisScore->setDateDeSaisie(date("Y-m-d H:i:s"));
                        $tab = explode(" - ", $formule->getResult());
                        $tennisScore->setEquipe1($tab[0]);
                        $tennisScore->setEquipe2($tab[1]);
                        $tennisScore->setNbSetPartie($tab[0]+$tab[1]);
                        if($tab[0]<$tab[1]) {
                            $tennisScore->setNbSetGagnant($tab[1]);
                        }else{
                            $tennisScore->setNbSetGagnant($tab[0]);
                        }
                        if ($tab[0] == 0 || $tab[1]==0){
                            $tennisScore->setFani(1);
                        }else{
                            $tennisScore->setFani(0);
                        }
                        if($tennisScore->getUn() <= $tennisScore->getDeux() ){
                            $tennisScore->setMincote($tennisScore->getUn());
                        }elseif ($tennisScore->getUn() > $tennisScore->getDeux()){
                            $tennisScore->setMincote($tennisScore->getDeux());
                        }

                        $em->persist($tennisScore);
                        $formule->setScoreTennis(2);
                        $em->persist($formule);
                        var_dump($tennisScore);
                        $em->flush();
                    }

                }


            }
        }
        $output->writeln(['============','resultat fin',]);
    }
}