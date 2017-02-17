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
use FdjBundle\Entity\MatchFini;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:test')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
//
            $tennisScores = $em->getRepository('FdjBundle:TennisScore')->findAll();

        foreach ($tennisScores as $tennisScore) {
            if($tennisScore->getEquipe1() == 0 || $tennisScore->getEquipe2()== 0 ){
                $tennisScore->setFani(1);
                $em->persist($tennisScore);
                $em->flush();
            }else{
                $tennisScore->setFani(0);
                $em->persist($tennisScore);
                $em->flush();
            }
        }



        $output->writeln(['============','resultat fin',]);
    }
}