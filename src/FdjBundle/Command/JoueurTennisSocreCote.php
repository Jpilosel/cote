<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 13/02/20
 * Time: 15:24
 */

namespace FdjBundle\Command;

use FdjBundle\Entity\TennisScore;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class JoueurTennisSocreCote extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fdj:JoueurTennisScoreCote')
            ->setDescription('MAJ JoueurTennisScoreCote.')
            ->setHelp("Cette commande lance une requette pour mettre a jour la table JoueurTennisScoreCote");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $matchs = $em->getRepository('FdjBundle:TennisScore')->findAll();
        foreach ($matchs as $match){
            if ($match->getJoueursTennis() == 1) {
                $joueur1s = explode("-", $match->getLabel());
                dump($joueur1s);
                $date = new \datetime($match->getDateDeSaisie());

                $joueur1 = new JoueurTennisScoreCote();
                $joueur1->setNom($joueur1s[0]);
                $joueur1->setCote($match->getUn());
                $joueur1->setNomAdversaire($joueur1s[1]);
                $joueur1->setCoteAdversaire($match->getDeux());
                $joueur1->setDate($date);
                $joueur1->setCompetiton($match->getCompetition());
                $joueur1->setResultat($match->getResultat());
                if ($match->getEquipe1() > $match->getEquipe2()) {
                    $joueur1->setVictoire(1);
                } elseif ($match->getEquipe1() < $match->getEquipe2()) {
                    $joueur1->setVictoire(0);
                }

                $joueur2 = new JoueurTennisScoreCote();
                $joueur2->setNom($joueur1s[1]);
                $joueur2->setCote($match->getDeux());
                $joueur2->setNomAdversaire($joueur1s[0]);
                $joueur2->setCoteAdversaire($match->getUn());
                $joueur2->setDate($date);
                $joueur2->setCompetiton($match->getCompetition());
                $joueur2->setResultat($match->getResultat());
                if ($match->getEquipe1() > $match->getEquipe2()) {
                    $joueur2->setVictoire(0);
                } elseif ($match->getEquipe1() < $match->getEquipe2()) {
                    $joueur2->setVictoire(1);
                }


                $match->setJoueursTennis('2');
                $em->persist($joueur1);
                $em->persist($joueur2);
                $em->persist($match);
                $em->flush();
                dump($joueur1);
                dump($joueur2);
            }
        }
        $output->writeln(['============','resultat fin',]);
    }

}