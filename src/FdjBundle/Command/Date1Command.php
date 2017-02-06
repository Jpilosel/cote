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

class Date1Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:date1')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();


        $date1s = $em->getRepository('FdjBundle:Formules')->findAll();
        foreach ($date1s as $date1) {
            $jour = date("Y-m-d");
            $date1bdd= $date1->getDateSasie();
            $interval = $date1bdd->diff($jour);
            var_dump($interval);
//            $em->persist($date1);
//            $em->flush();
        }

        $output->writeln(['============','resultat fin',]);
    }
}