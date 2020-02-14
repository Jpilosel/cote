<?php

namespace FdjBundle\Command;

use FdjBundle\Entity\CoteList;
use FdjBundle\Entity\TennisCoteCumul;
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

class TennisCoteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:tennisCote')
            ->setDescription('Reception des matchs avec la cote.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt','============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $coteListes = $em->getRepository('FdjBundle:CoteList')->findByCoteListTennisCote(600,1,1);
//        dump($coteListes);
        foreach ($coteListes as $coteListe){
            $tennisCoteCumul = $em->getRepository('FdjBundle:TennisCoteCumul')->findOneByCote($coteListe->getCote());
            if ($tennisCoteCumul == null){
                $newTennisCoteCumul = new TennisCoteCumul();
                $newTennisCoteCumul->setCote($coteListe->getCote());
                if ($coteListe->getResultat() == 'g'){
                    $newTennisCoteCumul->setWin(1);
                    $newTennisCoteCumul->setLoose(0);
                }elseif($coteListe->getResultat() == 'p'){
                    $newTennisCoteCumul->setWin(0);
                    $newTennisCoteCumul->setLoose(1);
                }
                $em->persist($newTennisCoteCumul);
                $em->flush();
            }else{
                if ($coteListe->getResultat() == 'g'){
                    $win = $tennisCoteCumul->getWin();
                    $win++;
                    $tennisCoteCumul->setWin($win);

                }elseif($coteListe->getResultat() == 'p'){
                    $loose = $tennisCoteCumul->getLoose();
                    $loose++;
                    $tennisCoteCumul->setLoose($loose);
                }
                $em->persist($tennisCoteCumul);
                $em->flush();
                $coteListe->setStatut(2);
                $em->persist($coteListe);
                $em->flush();
            }
        }
        $output->writeln(['============','cote fin',]);
    }
}