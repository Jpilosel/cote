<?php

namespace FdjBundle\Command;

use FdjBundle\Entity\AlgoMise;
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
use FdjBundle\Entity\MatchFini;
use FdjBundle\Entity\TennisScore;

class FootCoteCumulCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('fdj:footCoteCumul')
            ->setDescription('Reception des matchs avec les resultat.')
            ->setHelp("Cette commande lance une requette pour recevoir les matchs correspondant au sport");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['cote inputt', '============',]);
        $em = $this->getContainer()->get('doctrine')->getManager();
//        $formules = $em->getRepository('FdjBundle:Formules')->findByCoteListTennisCote(100,7,3);
//        foreach ($formules as $formule){
//            $formule->setOk(2);
//            $em->persist($formule);
//            $em->flush();
//        }
//        die;
//        $marketTypeIds = [7, 17];

//        $marketTypeIds = [34,7,17,33,37,21,22];
        $marketTypeIds = [1,2,3,15,7,17 ,34,33];
        if ($marketTypeIds == 1 || $marketTypeIds == 2 ||$marketTypeIds == 3 ||$marketTypeIds == 15 ||$marketTypeIds == 6 ||$marketTypeIds == 9 ||$marketTypeIds == 35){
            $nbCote = 3;
        }else{
            $nbCote = 2;
        }
        foreach ($marketTypeIds as $marketTypeId){
            dump($marketTypeId);
            $formules = $em->getRepository('FdjBundle:Formules')->findByCoteListTennisCote(100,$marketTypeId,2);
            foreach ($formules as $formule){
//                dump($formule);
                if($marketTypeId == 1){
                    $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), '1/N/2');
                }else {
                    $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), $formule->getMarketType());
                }
//                dump($sports);
                if ($sports != [] && $sports[0]->getUn() != null){
//                    dump($formule);
//                    dump($sports);
                    if($marketTypeId == 9 ||$marketTypeId == 1 ||$marketTypeId == 22 ||$marketTypeId == 21 ||$marketTypeId == 37 ||$marketTypeId == 33 ||$marketTypeId == 34){
                        $result[0] = $formule->getResult();
                    }elseif ($marketTypeId == 7 || $marketTypeId == 17){
                        $result = explode(' ', $formule->getResult());
                    }
//                    dump($result);
                    if ($result[0] == 'Plus' || $result[0] == 1 || $result[0] == 'Oui'){
//                    dump($result);
                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId,100);
                        dump($tennisCoteCumulUn);
                        if ($tennisCoteCumulUn == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getUn());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(1);
                            $newTennisCoteCumul->setLoose(0);
                            $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulUn = $tennisCoteCumulUn[0];
                            $tennisCoteCumulUn[0]->setWin($tennisCoteCumulUn[0]->getWin() +1);
                            $em->persist($tennisCoteCumulUn[0]);
                            $em->flush();
                        }
                        $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),$marketTypeId,100);
//                    dump($tennisCoteCumulDeux);
                        if ($tennisCoteCumulDeux == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getDeux());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(0);
                            $newTennisCoteCumul->setLoose(1);
                            $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                            $tennisCoteCumulDeux[0]->setLoose($tennisCoteCumulDeux[0]->getLoose()+1);
                            $em->persist($tennisCoteCumulDeux[0]);
                            $em->flush();
                        }
//                        dump($sports);
                        if ($nbCote == 3){
                            $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getNul(),$marketTypeId,100);
//                    dump($tennisCoteCumulDeux);
                            if ($tennisCoteCumulDeux == []){
                                $newTennisCoteCumul = new TennisCoteCumul();
                                $newTennisCoteCumul->setCote($sports[0]->getNul());
                                $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                                $newTennisCoteCumul->setWin(0);
                                $newTennisCoteCumul->setLoose(1);
                                $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                                $em->persist($newTennisCoteCumul);
                                $em->flush();
                            }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                                $tennisCoteCumulDeux[0]->setLoose($tennisCoteCumulDeux[0]->getLoose()+1);
                                $em->persist($tennisCoteCumulDeux[0]);
                                $em->flush();
                            }
                        }

                    }elseif($result[0] == 'Moins' || $result[0] == 2 || $result[0] == 'Non'){
//                    dump($result);
                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId,100);
                        dump($tennisCoteCumulUn);
                        if ($tennisCoteCumulUn == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getUn());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(0);
                            $newTennisCoteCumul->setLoose(1);
                            $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulUn = $tennisCoteCumulUn[0];
                            $tennisCoteCumulUn[0]->setLoose($tennisCoteCumulUn[0]->getLoose() +1);
//                        dump($tennisCoteCumulUn);
                            $em->persist($tennisCoteCumulUn[0]);
                            $em->flush();
                        }
//                    dump($sports[0]->getDeux());
                        $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),$marketTypeId,100);
//                    dump($tennisCoteCumulDeux);
                        if ($tennisCoteCumulDeux == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getDeux());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(1);
                            $newTennisCoteCumul->setLoose(0);
                            $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                            $tennisCoteCumulDeux[0]->setWin($tennisCoteCumulDeux[0]->getWin()+1);
                            $em->persist($tennisCoteCumulDeux[0]);
                            $em->flush();
                        }
                        if ($nbCote == 3){
                            $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getNul(),$marketTypeId,100);
//                    dump($tennisCoteCumulDeux);
                            if ($tennisCoteCumulDeux == []){
                                $newTennisCoteCumul = new TennisCoteCumul();
                                $newTennisCoteCumul->setCote($sports[0]->getNul());
                                $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                                $newTennisCoteCumul->setWin(0);
                                $newTennisCoteCumul->setLoose(1);
                                $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                                $em->persist($newTennisCoteCumul);
                                $em->flush();
                            }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                                $tennisCoteCumulDeux[0]->setLoose($tennisCoteCumulDeux[0]->getLoose()+1);
                                $em->persist($tennisCoteCumulDeux[0]);
                                $em->flush();
                            }
                        }elseif($nbCote == 3 && $result[0] == 'N'){
                            $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getNul(),$marketTypeId,100);
//                    dump($tennisCoteCumulDeux);
                            if ($tennisCoteCumulDeux == []){
                                $newTennisCoteCumul = new TennisCoteCumul();
                                $newTennisCoteCumul->setCote($sports[0]->getNul());
                                $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                                $newTennisCoteCumul->setWin(1);
                                $newTennisCoteCumul->setLoose(0);
                                $newTennisCoteCumul->setSport(100);
//                        dump($newTennisCoteCumul);
                                $em->persist($newTennisCoteCumul);
                                $em->flush();
                            }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                                $tennisCoteCumulDeux[0]->setLoose($tennisCoteCumulDeux[0]->getWin()+1);
                                $em->persist($tennisCoteCumulDeux[0]);
                                $em->flush();
                            }
                        }
                    }
                }
                $formule->setOk(3);
                $em->persist($formule);
                $em->flush();
            }
        }
        $output->writeln(['============','resultat fin',]);
    }
}