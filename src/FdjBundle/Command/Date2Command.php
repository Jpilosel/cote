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

class Date2Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:date2')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();


        $date1s = $em->getRepository('FdjBundle:Sport')->findAll();

        foreach ($date1s as $date1) {
            $date1 = date("Y-m-d H:i:s");
//            var_dump($jour);

            $date2 = $date1->getDateSasie();
//            var_dump($date1bdd);

//            $interval = abs(strtotime($jour)-strtotime($date1bdd));
            $retour = array();
            $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative


            $tmp = $diff;
            $retour['second'] = $tmp % 60;

            $tmp = floor( ($tmp - $retour['second']) /60 );
            $retour['minute'] = $tmp % 60;

            $tmp = floor( ($tmp - $retour['minute'])/60 );
            $retour['hour'] = $tmp % 24;

            $tmp = floor( ($tmp - $retour['hour'])  /24 );
            $retour['day'] = $tmp;
            var_dump($retour['day']);
        }
//            $em->persist($date1);
//            $em->flush();
//        foreach ($date1s as $date1) {
//            $date1->setDateSasie(date("Y-m-d H:i:s"));
//            $em->persist($date1);
//            $em->flush();
//        }

        $output->writeln(['============','resultat fin',]);
    }
}