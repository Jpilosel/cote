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
////        $algoMises = $em->getRepository('FdjBundle:AlgoMise')->findByAlgoMise('joel');
////        foreach ($algoMises as $algoMise){
////            $em->remove($algoMise);
////            $em->flush();
////        }
//        $cote = 1.25;
//        $txReussite = 76;
//        $marge = 1;
//        $palierPerdant = 2;
//        $coffreIncrementCase = 4;
//        $win = $loose = $palier = $caseActuelleDuCoffre = $HistoriqueNbParisPourBoucle = $nbParisPourBoucle =0;
//        $coffreDePertes = [];
//        $perte = $perteTotale = $solde = $perteMax = $soldeMinHisto = $miseMaxHisto = $mise = $testMeilleurParametre =0;
//        //-------------Test------------//
////        for ($a = 1; $a < 6; $a++) {
//            $win = $loose = $palier = $caseActuelleDuCoffre =0;
//            $coffreDePertes = [];
//            $perte = $perteTotale = $solde = $perteMax = $mise =0;
//            //--------Algoritme------------//
//
//            for ($i = 0; $i < 10000; $i++) {
//                $nbParisPourBoucle++;
////                    if ($perteMax > 10000){
//////                        dump('PERTE MAX : '.$perteMax.'---------------------------/');
////                        $i = 5000000;
////                        $stop = 1;
////                    }
////                dump('------------NV Paris -----------------------');
////                dump('Paris n°'.($i+1));
//
//                if ($coffreDePertes == []){
//                    $mise = round($marge/ ($cote-1),2);
//                }else{
//                    $mise = round(($coffreDePertes[0]['perte']+$marge)/($cote-1),2);
//                }
//                $solde = $solde -$mise;
////                dump('mise : '.$mise);
//                $tirage = rand(1, 100);
//                if ($tirage <= $txReussite) {
//                    $resultat = 1;
//                } else {
//                    $resultat = 2;
//                }
//                if ($resultat == 1) {
////                    dump('----------------GAGNANT-------------------------- : ');
//                    $win++;
//                } else {
//                    $loose++;
////                    dump('----------------PERDANT-------------------------- : ');
//                }
//
//                if ($resultat == 2) { //perdant//
//                    if ($coffreDePertes == []){
//                        $nbParisPourBoucle = 0;
//                        $coffreDePertes[0] = ['perte' => $mise, 'palier'=>2];
//                    }else{
//                        $perte = $case = 0;
//                        foreach ($coffreDePertes as $coffreDePerte){
//                            $perte = $perte + $coffreDePerte['perte'];
//                            $case = $case + 7;
//                        }
//                        $palier = $coffreDePertes[0]['palier'];
//                        if ($palier < $palierPerdant){
//                            $palier ++;
//                            $coffreDePertes[0]['palier']= $palier;
//                        }else{
//                            $case = $case + 7;
//                            $palier++;
//                            $perte = $perte + $mise + $marge;
//                            $coffreDePertes = [];
//                            for ($b = 0; $b < $case; $b++){
//                                if ($b == 0){
//                                    $coffreDePertes[$b]=['perte'=> ($perte/$case), 'palier'=>$palier];
//                                }else{
//                                    $coffreDePertes[$b]=['perte'=> ($perte/$case), 'palier'=>1];
//                                }
//
//                            }
//                        }
//
//                    }
//                } else {// Gagnant //
//                    $solde = $solde + $mise*$cote;
//                    if ($coffreDePertes == []){
//                        $nbParisPourBoucle = 0;
//                    }else{
//                        $case = 0;
//                        foreach ($coffreDePertes as $coffreDePerte){
//                            $case ++;
//                        }
////                        dump($case);
//                        if ($case == 1){
//                            $coffreDePertes=[];
//
//                        }else{
//                            $case = $case -1;
//                            $perte = $coffreDePertes[0]['perte'];
//                            $coffreDePertes = [];
//                            for ($b = 0; $b < $case; $b++){
//                                $coffreDePertes[$b]=['perte'=> $perte, 'palier'=>1];
//                            }
//                        }
//
//
//                    }
//
//                }
//                if ($nbParisPourBoucle > $HistoriqueNbParisPourBoucle){
//                    $HistoriqueNbParisPourBoucle = $nbParisPourBoucle;
//                }
////                dump('coffre de perte : ');
////                dump($coffreDePertes);
//                if ($soldeMinHisto > $solde){
//                    $soldeMinHisto = $solde;
//                }
////                Dump('solde : ' . $solde);
////                dump('victoire :' . $win . ', defaite : ' . $loose);
////                dump('soldeMin : ' . $soldeMinHisto);
////                dump('mise max : ' . $miseMaxHisto);
////                dump('Nombre de paris pour cloturer la boucle : ' . $HistoriqueNbParisPourBoucle);
//                if ($testMeilleurParametre == 0) {
//                    $testMeilleurParametre = $soldeMinHisto;
//                    $testResult = 'SoldeMin : ' . $soldeMinHisto . ', palierPerdant : ' . $palierPerdant;
//                } elseif ($testMeilleurParametre > $soldeMinHisto) {
//                    $testMeilleurParametre = $soldeMinHisto;
//                    $testResult = 'SoldeMin : ' . $soldeMinHisto . ', palierPerdant : ' . $palierPerdant;
//                }
////                dump($testResult);
//            }
////        }
//        dump($testResult);
//
//        die;
//
//
//
//
//        $nbPalier= 2;
//        $serieDeGain = 0;
//        $cote = 1.65 - 1;
//        $perte = $pertePrecedente =  $setMise = $setPerte = 0;
//        $marge = 0.1;
//        for ($i=0; $i<3000; $i++){
//            $resultat = rand(1,2);
//            dump($resultat);
//            if($serieDeGain == 0){
//                $gainAGenerer = round($perte/$nbPalier,2, PHP_ROUND_HALF_UP);
//                $mise = round(($gainAGenerer+0.1)/($cote),3);
////                    dump($nbPalier);
//                dump($gainAGenerer);
//            }elseif ($serieDeGain <= $nbPalier){
//                $gainAGenerer = round($pertePrecedente/$nbPalier,2);
//                dump($gainAGenerer);
//                $mise = round(($gainAGenerer+$marge)/($cote),3,PHP_ROUND_HALF_UP);
//            }else{
//                $mise = round(($marge)/$cote,3,PHP_ROUND_HALF_UP);
//            }
//            dump($mise);
//            dump($pertePrecedente);
//            if ($resultat == 1){
//                $$serieDeGain = $serieDeGain+1;
//                $perte = ($perte-($mise*($cote+1) - $mise));
//                if ($serieDeGain > $nbPalier){
//                    $serieDeGain = 0;
//                    $pertePrecedente = (0);
//                    $perte = (0);
//                }
//            }elseif ($resultat == 2){
//                $serieDeGain = 0;
//                $pertePrecedente = ($perte +$mise + $marge);
//                $perte = ($perte + $mise+ $marge);
//                $serieDeGain = (0);
//            }
//            if ($setMise < $mise){
//                $setMise = $mise;
//            }
//            if ($setPerte < $perte){
//                $setPerte = $perte;
//            }
//        }
//        echo 'perte max : ';
//        dump($setPerte);
//        echo 'mise max : ';
//        dump($setMise);
//
//
//
//
//        die;
        $marketTypeIds = [7, 17, 29];
//        $marketTypeIds = [1, 7, 17];
        foreach ($marketTypeIds as $marketTypeId){
            dump($marketTypeId);
            $formules = $em->getRepository('FdjBundle:Formules')->findByCoteListTennisCote(600,$marketTypeId,2);
            foreach ($formules as $formule){
//                dump($formule);
                if($marketTypeId == 1){
                    $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), '1/N/2');
                }elseif ($marketTypeId == 7){
                    $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), $formule->getMarketType());
                }elseif ($marketTypeId == 17){
                    $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), $formule->getMarketType());
                }
//                dump($sports);
                if ($sports != []){
//                    dump($formule);
//                    dump($sports);
                    if($marketTypeId == 1){
                        $result[0] = $formule->getResult();
                    }elseif ($marketTypeId == 7 || $marketTypeId == 17){
                        $result = explode(' ', $formule->getResult());
                    }
//                    dump($result);
                    if ($result[0] == 'Plus' || $result[0] == 1  ){
//                    dump($result);
                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId);
                        dump($tennisCoteCumulUn);
                        if ($tennisCoteCumulUn == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getUn());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(1);
                            $newTennisCoteCumul->setLoose(0);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulUn = $tennisCoteCumulUn[0];
                            $tennisCoteCumulUn[0]->setWin($tennisCoteCumulUn[0]->getWin() +1);
                            $em->persist($tennisCoteCumulUn[0]);
                            $em->flush();
                        }
                        $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),$marketTypeId);
//                    dump($tennisCoteCumulDeux);
                        if ($tennisCoteCumulDeux == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getDeux());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(0);
                            $newTennisCoteCumul->setLoose(1);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                            $tennisCoteCumulDeux[0]->setLoose($tennisCoteCumulDeux[0]->getLoose()+1);
                            $em->persist($tennisCoteCumulDeux[0]);
                            $em->flush();
                        }

                    }elseif($result[0] == 'Moins' || $result[0] == 2){
//                    dump($result);
                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId);
                        dump($tennisCoteCumulUn);
                        if ($tennisCoteCumulUn == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getUn());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(0);
                            $newTennisCoteCumul->setLoose(1);
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
                        $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),$marketTypeId);
//                    dump($tennisCoteCumulDeux);
                        if ($tennisCoteCumulDeux == []){
                            $newTennisCoteCumul = new TennisCoteCumul();
                            $newTennisCoteCumul->setCote($sports[0]->getDeux());
                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
                            $newTennisCoteCumul->setWin(1);
                            $newTennisCoteCumul->setLoose(0);
//                        dump($newTennisCoteCumul);
                            $em->persist($newTennisCoteCumul);
                            $em->flush();
                        }else{
//                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
                            $tennisCoteCumulDeux[0]->setWin($tennisCoteCumulDeux[0]->getWin()+1);
                            $em->persist($tennisCoteCumulDeux[0]);
                            $em->flush();
                        }
                    }
                }
                $formule->setOk(3);
                $em->persist($formule);
                $em->flush();
            }
        }

////        $marketTypeIds = [1, 7];
//        $marketTypeIds = [7];
//        foreach ($marketTypeIds as $marketTypeId){
//            $formules = $em->getRepository('FdjBundle:Formules')->findByCoteListTennisCote(600,$marketTypeId,2);
//            foreach ($formules as $formule){
////            dump($formule);
//                $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), $formule->getMarketType());
////            dump($sports);
//                if ($sports != []){
////                dump($formule);
////                dump($sports[0]);
//                    $result = explode(' ', $formule->getResult());
////                dump($result);
//                    if ($result[0] == 'Plus'){
////                    dump($result);
//                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId);
////                    dump($tennisCoteCumulUn);
//                        if ($tennisCoteCumulUn == []){
//                            $newTennisCoteCumul = new TennisCoteCumul();
//                            $newTennisCoteCumul->setCote($sports[0]->getUn());
//                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
//                            $newTennisCoteCumul->setWin(1);
//                            $newTennisCoteCumul->setLoose(0);
////                        dump($newTennisCoteCumul);
//                            $em->persist($newTennisCoteCumul);
//                            $em->flush();
//                        }else{
////                        $tennisCoteCumulUn = $tennisCoteCumulUn[0];
//                            $tennisCoteCumulUn[0]->setWin($tennisCoteCumulUn[0]->getWin() +1);
//                            $em->persist($tennisCoteCumulUn[0]);
//                            $em->flush();
//                        }
//                        $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),$marketTypeId);
////                    dump($tennisCoteCumulDeux);
//                        if ($tennisCoteCumulDeux == []){
//                            $newTennisCoteCumul = new TennisCoteCumul();
//                            $newTennisCoteCumul->setCote($sports[0]->getDeux());
//                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
//                            $newTennisCoteCumul->setWin(0);
//                            $newTennisCoteCumul->setLoose(1);
////                        dump($newTennisCoteCumul);
//                            $em->persist($newTennisCoteCumul);
//                            $em->flush();
//                        }else{
////                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
//                            $tennisCoteCumulDeux[0]->setLoose($tennisCoteCumulDeux[0]->getLoose()+1);
//                            $em->persist($tennisCoteCumulDeux[0]);
//                            $em->flush();
//                        }
//
//                    }elseif($result[0] == 'Moins'){
////                    dump($result);
//                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId);
////                    dump($tennisCoteCumulUn);
//                        if ($tennisCoteCumulUn == []){
//                            $newTennisCoteCumul = new TennisCoteCumul();
//                            $newTennisCoteCumul->setCote($sports[0]->getUn());
//                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
//                            $newTennisCoteCumul->setWin(0);
//                            $newTennisCoteCumul->setLoose(1);
////                        dump($newTennisCoteCumul);
//                            $em->persist($newTennisCoteCumul);
//                            $em->flush();
//                        }else{
////                        $tennisCoteCumulUn = $tennisCoteCumulUn[0];
//                            $tennisCoteCumulUn[0]->setLoose($tennisCoteCumulUn[0]->getLoose() +1);
////                        dump($tennisCoteCumulUn);
//                            $em->persist($tennisCoteCumulUn[0]);
//                            $em->flush();
//                        }
////                    dump($sports[0]->getDeux());
//                        $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),$marketTypeId);
////                    dump($tennisCoteCumulDeux);
//                        if ($tennisCoteCumulDeux == []){
//                            $newTennisCoteCumul = new TennisCoteCumul();
//                            $newTennisCoteCumul->setCote($sports[0]->getDeux());
//                            $newTennisCoteCumul->setMarketTypeId($marketTypeId);
//                            $newTennisCoteCumul->setWin(1);
//                            $newTennisCoteCumul->setLoose(0);
////                        dump($newTennisCoteCumul);
//                            $em->persist($newTennisCoteCumul);
//                            $em->flush();
//                        }else{
////                        $tennisCoteCumulDeux = $tennisCoteCumulDeux[0];
//                            $tennisCoteCumulDeux[0]->setWin($tennisCoteCumulDeux[0]->getWin()+1);
//                            $em->persist($tennisCoteCumulDeux[0]);
//                            $em->flush();
//                        }
//                    }
//                }
//                $formule->setOk(3);
//                $em->persist($formule);
//                $em->flush();
//            }
//        }



//        $output->writeln(['cote inputt', '============',]);
//        $em = $this->getContainer()->get('doctrine')->getManager();
////
//        $em = $this->getContainer()->get('doctrine')->getManager();
//        $matchs = $em->getRepository('FdjBundle:TennisScore')->findAll();
//        foreach ($matchs as $match){
//            if ($match->getJoueursTennis() == 1) {
//                $joueur1s = explode("-", $match->getLabel());
//                dump($joueur1s);
//                $date = new \datetime($match->getDateDeSaisie());
//
//                $joueur1 = new JoueurTennisScoreCote();
//                $joueur1->setNom($joueur1s[0]);
//                $joueur1->setCote($match->getUn());
//                $joueur1->setNomAdversaire($joueur1s[1]);
//                $joueur1->setCoteAdversaire($match->getDeux());
//                $joueur1->setDate($date);
//                $joueur1->setCompetiton($match->getCompetition());
//                $joueur1->setResultat($match->getResultat());
//                if ($match->getEquipe1() > $match->getEquipe2()) {
//                    $joueur1->setVictoire(1);
//                } elseif ($match->getEquipe1() < $match->getEquipe2()) {
//                    $joueur1->setVictoire(0);
//                }
//
//                $joueur2 = new JoueurTennisScoreCote();
//                $joueur2->setNom($joueur1s[1]);
//                $joueur2->setCote($match->getDeux());
//                $joueur2->setNomAdversaire($joueur1s[0]);
//                $joueur2->setCoteAdversaire($match->getUn());
//                $joueur2->setDate($date);
//                $joueur2->setCompetiton($match->getCompetition());
//                $joueur2->setResultat($match->getResultat());
//                if ($match->getEquipe1() > $match->getEquipe2()) {
//                    $joueur2->setVictoire(0);
//                } elseif ($match->getEquipe1() < $match->getEquipe2()) {
//                    $joueur2->setVictoire(1);
//                }
//
//
//                $match->setJoueursTennis('2');
//                $em->persist($joueur1);
//                $em->persist($joueur2);
//                $em->persist($match);
//                $em->flush();
//                dump($joueur1);
//                dump($joueur2);
//            }
//        }



        $output->writeln(['============','resultat fin',]);
    }
}