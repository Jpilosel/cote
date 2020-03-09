<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\AlgoMise;
use FdjBundle\Entity\ApiResultatTennis;
use FdjBundle\Entity\Calculette;
use FdjBundle\Entity\ClassementJoueurs;
use FdjBundle\Entity\JoueursTennis;
use FdjBundle\Entity\JoueurTennisScoreCote;
use FdjBundle\Entity\TennisCoteCumul;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FdjBundle\Entity\CoteList;
use Symfony\Component\Validator\Constraints\DateTime;
use FdjBundle\Entity\TennisScore;
use FdjBundle\Entity\TableCorrespondance;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="resultat_coteList")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('FdjBundle\Form\CoteListType');
        $form->handleRequest($request);
        $gagnant = $perdant = $tauxReussite = $cote = $max = 0;
        $exist = $nbaris = $listes = $listes = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $cote = $data['cote'];
            $cote2decimal = number_format($cote, 2, ',', '');
//            $cote= str_replace('.',',',$data['cote']);
            $data['cote']=$cote2decimal;
            $cotes = $em->getRepository('FdjBundle:CoteList')->findAll();
            foreach ($cotes as $cotetemp) {
                $temp = $cotetemp->getCote();
//                var_dump($temp);
                if ($max < $temp) {
                    $max = $temp;
                }
            }
            $resultats = $em->getRepository('FdjBundle:CoteList')->findByCoteListResult($data);
            $nbaris = count($resultats);
            if (!$nbaris){
                $exist = 1;
            }
            foreach ($resultats as $resultat) {
                if ($resultat->getResultat() == 'g'){
                    $gagnant++;
                }elseif ($resultat->getResultat() == 'p'){
                    $perdant++;
                }

            }
//            var_dump($nbaris);
//            var_dump($gagnant);
//            var_dump($perdant);
            if ($nbaris) {
                $tauxReussite = round(($gagnant / $nbaris) * 100, 2);
            }else{
                $tauxReussite = 'pas de paris pour cette selection';
            }

            $a=0;

            for ($i=1; $i<=$max; $i=$i+0.01){
//var_dump($i);
//var_dump($data);
                $ivirgule = number_format($i, 2, ',', '');
                $cotestring = (string)$ivirgule;
//                var_dump($cotestring);
                $data['cote']=$cotestring;
//                var_dump($data);
                $listeGagnant= $listePerdant =0;
                $coteResultats = $em->getRepository('FdjBundle:CoteList')->findByCoteListResult($data);

                if ($coteResultats) {
                    $listes[$a]['gagnant'] = 0 ;
                    $listes[$a]['perdant'] = 0 ;
                    $nbaris = count($coteResultats);
//                    var_dump($nbaris);

                    foreach ($coteResultats as $coteResultat) {


//                        var_dump($coteResultat);
                        if ($coteResultat->getResultat() == 'g'){
                            $listeGagnant=$listeGagnant+1;
                            $listes[$a]['gagnant'] = $listeGagnant ;

                        }elseif ($coteResultat->getResultat() == 'p'){
                            $listePerdant=$listePerdant+1;
                            $listes[$a]['perdant'] = $listePerdant ;

                        }
//                        var_dump($listes);
                    }
                    $listes[$a]['cote']=$cotestring ;
                    $listes[$a]['nbParis']=$listeGagnant+$listePerdant ;
                    $listes[$a]['txreussite']=round(($listeGagnant/($listeGagnant+$listePerdant))*100,2) ;
                    $a++;
                }
            }
//            var_dump($listes);


            return $this->render('FdjBundle:Default:index.html.twig', array(
                'form' => $form->createView(),
                'cote'=>$cote,
                'nbParis' => $nbaris,
                'nbGagnant' => $gagnant,
                'nbPerdant' => $perdant,
                'tauxreussite' => $tauxReussite,
                'exist' =>$exist,
                'listes' =>$listes,
            ));
        }

        return $this->render('FdjBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'cote'=>$cote,
            'nbParis' => $nbaris,
            'nbGagnant' => $gagnant,
            'nbPerdant' => $perdant,
            'tauxreussite' => $tauxReussite,
            'exist' =>$exist,
            'listes' =>$listes,
            ));
    }

    /**
     * @Route("/testApi", name="resultat_testApi")
     */
    public function ApiTestAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $tennisScores = $em->getRepository('FdjBundle:TennisScore')->findByJoueursTennis(1);
//        dump($tennisScores);
        if ($tennisScores != null){
            foreach ($tennisScores as $tennisScore){
//                dump($tennisScore);
                $doublon = $em->getRepository('FdjBundle:JoueursTennis')->findByIdEvent($tennisScore->getEventId());
                if($doublon == null){
                    if ($tennisScore->getEventID())
//                dump($tennisScore);
                        if (substr_count($tennisScore->getLabel(), '/' ) == 0) {
                            $noms = explode('-', $tennisScore->getLabel());
//                            dump($noms);
                            $joueur1 = $noms[0];
                            $joueur2 = $noms[1];
                            dump($joueur1);
                            dump($joueur2);
                            dump(stripos($joueur1, '.'));
                            dump(stripos($joueur2, '.'));
                            if (stripos($joueur1, '.') != null){
                                $joueur1Nom = explode('.', $joueur1)[1];
                            }
                            if (stripos($joueur2, '.') != null){
                                $joueur2Nom = explode('.', $joueur2)[1];
                            }else{
                                $joueur2Nom = $joueur2;
                            }
                    dump($joueur2Nom);
                            $apiClassementJoueurs1 = null;
                            $apiClassementJoueurs1 = $em->getRepository('FdjBundle:ClassementJoueurs')->findByNom($joueur1Nom);

                    dump($apiClassementJoueurs1);
                            if ($apiClassementJoueurs1 == null) {
                                $apiJoueur1 = null;
                            } elseif (count($apiClassementJoueurs1) == 1) {
                                $apiJoueur1 = $apiClassementJoueurs1[0];
                            } else {
                                $apiJoueur1 = $apiClassementJoueurs1[0];

                                foreach ($apiClassementJoueurs1 as $apiClassementJoueur1) {
                                    if ($apiClassementJoueur1->getId() > $apiJoueur1->getId()) {
                                        $apiJoueur1 = $apiClassementJoueur1;
                                    }
                                }
                            }
                    dump($apiJoueur1);
                            $joueursTennis = new JoueursTennis();
                            $joueursTennis->setNom($joueur1Nom);
                            if ($apiJoueur1 != null) {
                                $joueursTennis->setPrenom($apiJoueur1->getPrenom());
                                if ($apiJoueur1 != null) {
                                    $joueursTennis->setFullIdJoueurs($apiJoueur1->getIdJoueur());

                                    $idJoueurs1 = explode(':', $apiJoueur1->getIdJoueur())[2];
                                    $joueursTennis->setIdJoueur($idJoueurs1);
                                    $sexe = null;
                                    if ($apiJoueur1->getType() == "ATP") {
                                        $sexe = 'Homme';
                                    } elseif ($apiJoueur1->getType() == "WTA") {
                                        $sexe = 'Femme';
                                    }
//                    dump($sexe);
                                    $joueursTennis->setSexe($sexe);
                                    if ($apiJoueur1 != null) {
                                        $joueursTennis->setClassementAtpWta($apiJoueur1->getRang());
                                    }
                                }
                                $joueursTennis->setIdEvent($tennisScore->getEventId());
                                if ($tennisScore->getEquipe1() > $tennisScore->getEquipe2()) {
                                    $joueursTennis->setStatus('Gagnant');
                                } elseif ($tennisScore->getEquipe1() < $tennisScore->getEquipe2()) {
                                    $joueursTennis->setStatus('Perdant');
                                }
                                $joueursTennis->setCote($tennisScore->getUn());
                                $joueursTennis->setCoteAdversaire($tennisScore->getDeux());
                                $joueursTennis->setNbSet($tennisScore->getEquipe1() + $tennisScore->getEquipe2());
                                $joueursTennis->setIdCompetiton($tennisScore->getcompetitionId());
                                $joueursTennis->setType('single');
                                $joueursTennis->setNomAdversaire($joueur2);

                                $apiClassementJoueurs2 = null;
                                $apiClassementJoueurs2 = $em->getRepository('FdjBundle:ClassementJoueurs')->findByNom($joueur2Nom);

                    dump($apiClassementJoueurs2);
                                if ($apiClassementJoueurs2 == null) {
                                    $apiJoueur2 = null;
                                } elseif (count($apiClassementJoueurs2) == 1) {
                                    $apiJoueur2 = $apiClassementJoueurs2[0];
                                } else {
                                    $apiJoueur2 = $apiClassementJoueurs2[0];

                                    foreach ($apiClassementJoueurs2 as $apiClassementJoueur2) {
                                        if ($apiClassementJoueur2->getId() > $apiJoueur2->getId()) {
                                            $apiJoueur2 = $apiClassementJoueur2;
                                        }
                                    }
                                }
                                dump($apiJoueur1);
                                dump($apiJoueur2);
                                if ($apiJoueur2 != null) {
                                    $joueursTennis->setClassementAtpAdversaire($apiJoueur2->getRang());
                                }
                                $em->persist($joueursTennis);
                                $em->flush();
                                dump($apiJoueur2);
                                $joueursTennis2 = new JoueursTennis();

                                $joueursTennis2->setNom($joueur2Nom);
                                if ($apiJoueur2 == null) {
                                    $joueursTennis2->setPrenom($joueur2);
                                }
                                if ($apiJoueur2 != null) {
                                    $joueursTennis2->setPrenom($apiJoueur2->getPrenom());
                                    $joueursTennis2->setFullIdJoueurs($apiJoueur2->getIdJoueur());
                                    $idJoueurs2 = explode(':', $apiJoueur2->getIdJoueur())[2];
                                    $joueursTennis2->setIdJoueur($idJoueurs2);
                                    $joueursTennis2->setSexe($sexe);
                                    if ($apiJoueur2 != null) {
                                        $joueursTennis2->setClassementAtpWta($apiJoueur2->getRang());
                                    }
                                }
                                $joueursTennis2->setIdEvent($tennisScore->getEventId());
                                if ($tennisScore->getEquipe2() > $tennisScore->getEquipe1()) {
                                    $joueursTennis2->setStatus('Gagnant');
                                } elseif ($tennisScore->getEquipe2() < $tennisScore->getEquipe1()) {
                                    $joueursTennis2->setStatus('Perdant');
                                }
                                $joueursTennis2->setCote($tennisScore->getDeux());
                                $joueursTennis2->setCoteAdversaire($tennisScore->getUn());
                                $joueursTennis2->setNbSet($tennisScore->getEquipe1() + $tennisScore->getEquipe2());
                                $joueursTennis2->setIdCompetiton($tennisScore->getcompetitionId());
                                $joueursTennis2->setType('single');
                                $joueursTennis2->setNomAdversaire($joueur1);

                                if ($apiJoueur1 != null) {
                                    $joueursTennis2->setClassementAtpAdversaire($apiJoueur1->getRang());
                                }
//                    dump($joueursTennis2);
                                $em->persist($joueursTennis2);
                                $em->flush();

                            }
                        }
                }


            }
        }


//        dump($tennisScores);


        return $this->render('FdjBundle:Default:index.html.twig');

    }

    /**
     * @Route("/ficheJoueur", name="ficheJoueur")
     */
    public function JoueurAction(Request $request)
    {
        $form = $this->createForm('FdjBundle\Form\JoueurTennisType');
        $form->handleRequest($request);
        $classementAtp = $listeMatchs = $classementAtps = $listeClassements= $moyenne = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            dump($form->getData()['nomJoueur']);
            $listeMatchs = $em->getRepository('FdjBundle:ApiResultatTennis')->findByFullIdJoueurs($form->getData()['nomJoueur']);
            $classementAtp = $em->getRepository('FdjBundle:ClassementJoueurs')->findByIdJoueur($form->getData()['nomJoueur']);
            $classementAtps = $em->getRepository('FdjBundle:ClassementJoueurs')->findByJoueur($form->getData()['nomJoueur']);
            $cumul = $nb = 0;
            foreach ($classementAtp as $classement){
                $cumul = $cumul + $classement->getRang();
                $nb++;
            }
            $moyenne = round($cumul/$nb);
            dump($listeMatchs);
            dump($classementAtp);
            foreach ($listeMatchs as $key=>$listeMatch){
                $nSemaine = $listeMatch->getDate()->format('W');
                $annee = $listeMatch->getDate()->format('Y');
                $matchClassementAtpsJ1 = $em->getRepository('FdjBundle:ClassementJoueurs')->findByWeek($form->getData()['nomJoueur'], $nSemaine, $annee);
                if ($matchClassementAtpsJ1 == []){
                    $listeClassements[$key]['classementJ1'] = null;
                }else{
                    dump($matchClassementAtpsJ1);
                    $listeClassements[$key]['classementJ1'] = $matchClassementAtpsJ1[0]->getRang();
                }

                if ( $form->getData()['nomJoueur'] == $listeMatch->getJoueur1Id()){
                    $adversaire = $listeMatch->getJoueur2Id();
                }else {
                    $adversaire = $listeMatch->getJoueur1Id();
                }
                dump($listeMatch->getJoueur1Id());
                dump($form->getData()['nomJoueur']);
                $matchClassementAtpsJ2 = $em->getRepository('FdjBundle:ClassementJoueurs')->findByWeek($adversaire, $nSemaine, $annee);
                if ($matchClassementAtpsJ2 == []){
                    $listeClassements[$key]['adversaire'] = $listeClassements[$key]['adversaireMoyenne'] = null;
                }else{
                    dump($matchClassementAtpsJ2);
                    $listeClassements[$key]['adversaire'] = $matchClassementAtpsJ2[0]->getRang();
                    $classementAdversaires = $em->getRepository('FdjBundle:ClassementJoueurs')->findByWeekInf($form->getData()['nomJoueur'], $nSemaine, $annee);
                    $cumul2 = $nb2 = 0;
                    foreach ($classementAdversaires as $classement){
                        $cumul2 = $cumul2 + $classement->getRang();
                        $nb2++;
                    }
                    $moyenne = round($cumul2/$nb2);
                    $listeClassements[$key]['adversaireMoyenne'] = $moyenne;
                }

                dump($listeClassements);
            }

        }



        return $this->render('FdjBundle:Default:ficheJoueur.html.twig', array(
            'form' => $form->createView(),
            'classementAtp' => $classementAtp[0],
            'classementAtps' => $classementAtps,
            'listeMatchs' => $listeMatchs,
            'listeClassements' => $listeClassements,
            'moyenne'=> $moyenne,
        ));
    }

    /**
     * @Route("/test2", name="test2")
     */
    public function test2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $correspondances  = $em->getRepository('FdjBundle:TableCorrespondance')->findAll();
        foreach ($correspondances as $correspondance){
            $bdds  = $em->getRepository('FdjBundle:ClassementJoueurs')->findByJoueur($correspondance->getIdSportRadar());
            $tour =1;
            foreach ($bdds as $bdd){
                dump($bdd->getSemaine());
                dump($bdd->getRang());
//                dump($bdd->getRangMouvement());

                if ($tour == 1){
                    $oldClassement = $bdd->getRang();
                    dump($oldClassement);
                    $tour = 2;
                }else{
                    $evolClassement = $bdd->getRang() - $oldClassement;
                    dump($evolClassement);
                    if ($bdd->getRangMouvement() == null){
                        $bdd->setRangMouvement($evolClassement);
                        $em->persist($bdd);
                        $em->flush();
                    }
                }


            }

        }
die;



            }

    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();
        $marketTypeIds = [1, 7];
        foreach ($marketTypeIds as $marketTypeId){
            $formules = $em->getRepository('FdjBundle:Formules')->findByCoteListTennisCote(600,$marketTypeId,2);//-----------------------passer le 2 a 1 -------///
            foreach ($formules as $formule){
            dump($formule);
            if($marketTypeId == 1){
                $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), '1/N/2');
            }elseif ($marketTypeId == 7){
                $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), $formule->getMarketType());
            }
            dump($sports);
                if ($sports != []){
                    dump($formule);
                    dump($sports);
                    if($marketTypeId == 1){
                        $result[0] = $formule->getResult();
                    }elseif ($marketTypeId == 7){
                        $result = explode(' ', $formule->getResult());
                    }
                dump($result);
                    if ($result[0] == 'Plus' || $result[0] == 1  ){
//                    dump($result);
                        $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),$marketTypeId);
//                    dump($tennisCoteCumulUn);
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
//                    dump($tennisCoteCumulUn);
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
//        $coteListes = $em->getRepository('FdjBundle:CoteList')->findByCoteListTennisCote(600,1,1);
//        dump($coteListes);
//        foreach ($coteListes as $coteListe){
//            dump($coteListe->getCote());
//            $tennisCoteCumul = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($coteListe->getCote(),1);
//            dump($tennisCoteCumul);
//            if ($tennisCoteCumul == []){
//                $newTennisCoteCumul = new TennisCoteCumul();
//                $newTennisCoteCumul->setCote($coteListe->getCote());
//                $newTennisCoteCumul->setMarketTypeId(1);
//                if ($coteListe->getResultat() == 'g'){
//                    $newTennisCoteCumul->setWin(1);
//                    $newTennisCoteCumul->setLoose(0);
//                }elseif($coteListe->getResultat() == 'p'){
//                    $newTennisCoteCumul->setWin(0);
//                    $newTennisCoteCumul->setLoose(1);
//                }
//                dump($newTennisCoteCumul);
//                $em->persist($newTennisCoteCumul);
//                $em->flush();
//            }else{
//                if ($coteListe->getResultat() == 'g'){
//                    $win = $tennisCoteCumul->getWin();
//                    $win++;
//                    $tennisCoteCumul->setWin($win);
//
//                }elseif($coteListe->getResultat() == 'p'){
//                    $loose = $tennisCoteCumul->getLoose();
//                    $loose++;
//                    $tennisCoteCumul->setLoose($loose);
//                }
//                $em->persist($tennisCoteCumul);
//                $em->flush();
//                $coteListe->setStatut(2);
//                $em->persist($coteListe);
//                $em->flush();
//            }
//
//        }
        $formules = $em->getRepository('FdjBundle:Formules')->findByCoteListTennisCote(600,7,2);
        foreach ($formules as $formule){
            $sports = $em->getRepository('FdjBundle:Sport')->findByCoteListTennisCote($formule->getEventId(), $formule->getMarketType());
            if ($sports != []){
//                dump($formule);
//                dump($sports[0]);
                $result = explode(' ', $formule->getResult());
//                dump($result);
                if ($result[0] == 'Plus'){
//                    dump($result);
                    $tennisCoteCumulUn = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getUn(),7);
//                    dump($tennisCoteCumulUn);
                    if ($tennisCoteCumulUn == []){
                        $newTennisCoteCumul = new TennisCoteCumul();
                        $newTennisCoteCumul->setCote($sports[0]->getUn());
                        $newTennisCoteCumul->setMarketTypeId(7);
                        $newTennisCoteCumul->setWin(1);
                        $newTennisCoteCumul->setLoose(0);
//                        dump($newTennisCoteCumul);
                        $em->persist($newTennisCoteCumul);
                        $em->flush();
                    }else{
                        $tennisCoteCumulUn->setWin($tennisCoteCumulUn->setWin+1);
                        $em->persist($tennisCoteCumulUn);
                        $em->flush();
                    }
                    $tennisCoteCumulDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByCoteMarketTypeId($sports[0]->getDeux(),7);
//                    dump($tennisCoteCumulDeux);
                    if ($tennisCoteCumulDeux == []){
                        $newTennisCoteCumul = new TennisCoteCumul();
                        $newTennisCoteCumul->setCote($sports[0]->getUn());
                        $newTennisCoteCumul->setMarketTypeId(7);
                        $newTennisCoteCumul->setWin(0);
                        $newTennisCoteCumul->setLoose(1);
//                        dump($newTennisCoteCumul);
                        $em->persist($newTennisCoteCumul);
                        $em->flush();
                    }else{
                        $tennisCoteCumulDeux->setLoose($tennisCoteCumulDeux->setWin+1);
                        $em->persist($tennisCoteCumulDeux);
                        $em->flush();
                    }

                }
            }
            $formule->setOk(3);
            $em->persist($formule);
            $em->flush();

        }

        die;
//        $api = '';
//        $datas = json_decode($api, true);
//        foreach ($datas['result']['extractorData']['data'][0]['group'] as $data) {
//            if (isset($data['Link'])) {
//                $nomComplet = $data['Link'][0]['text'];
//                $doublon = $em->getRepository('FdjBundle:TableCorrespondance')->findByImportScraper($nomComplet);
//                if ($doublon == null) {
//                    $joueur = new TableCorrespondance();
//                    $joueur->setImportScraper($nomComplet);
//                    $em->persist($joueur);
//                    $em->flush();
//                }
//            }
//        }
//        die;
//        $bdds = $em->getRepository('FdjBundle:TableCorrespondance')->findAll();
////        dump($bdds);
//        foreach ($bdds as $bdd) {
//            if ($bdd->getSportRadar() == null) {
//                $nomEnregistre = $bdd->getImportScraper();
//                $nomExplod = explode(' ', $nomEnregistre);
//                $prenom = $nomExplod[0];
//                if (count($nomExplod) > 1) {
//                    $nom = $nomExplod[count($nomExplod) - 2];
//                    $classementjoueur = $em->getRepository('FdjBundle:ClassementJoueurs')->findOneByNom($nom);
//                    if ($classementjoueur == null) {
//                        $classementjoueur = $em->getRepository('FdjBundle:ClassementJoueurs')->findOneByPrenom($prenom);
//                    }
//                    dump($classementjoueur);
//                    $bdd->setSportRadar($classementjoueur->getNomJoueurs());
//                    $bdd->setIdSportRadar($classementjoueur->getIdJoueur());
//                    $em->persist($bdd);
//                    $em->flush();
//
//                }
//            }
//        }
//        die;


//        $semaine = '1';
//        $annee = '2019';
//        $type = 'ATP';
//        $api = '';
//        $datas = json_decode($api, true);
////        dump($scrap);
////        dump($datas['result']['extractorData']['data'][0]['group'][1]);
//        foreach ($datas['result']['extractorData']['data'][0]['group'] as $data){
//            if (isset($data['Link'])){
////                dump($data);
//                $joueur = new ClassementJoueurs();
//                $joueur->setType($type);
//                $joueur->setAnnee($annee);
//                $joueur->setSemaine($semaine);
//                $nomComplet = $data['Link'][0]['text'];
//                $correspondance  = $em->getRepository('FdjBundle:TableCorrespondance')->findOneByImportScraper($nomComplet);
//                $nomExplod = explode(' ', $nomComplet);
//                if (count($nomExplod) > 1){
//                    $nomJoueur = $nomExplod[count($nomExplod)-2];
//                    dump($nomJoueur);
//                    if ($correspondance != null){
//                        $bdds  = $em->getRepository('FdjBundle:ClassementJoueurs')->findOneByIdJoueur($correspondance->getIdSportRadar());
//                        //                    dump($bdds);
//                        if ($bdds != null){
//                            $joueur->setIdJoueur($bdds->getIdJoueur());
//                            if ($bdds->getNomJoueurs() != null){
//                                $joueur->setNomJoueurs($bdds->getNomJoueurs());
//                            }else{
//                                $joueur->setNom($nomJoueur);
//                            }
//                            $joueur->setNomJoueurs($bdds->getNomJoueurs());
//                            $joueur->setPrenom($bdds->getPrenom());
//                            $joueur->setNationalite($bdds->getNationalite());
//                        }else{
//                            $joueur->setNomJoueurs($data['Link'][0]['text']);
//                            $tableCorrespondance = new TableCorrespondance();
//                            $tableCorrespondance->setImportScraper($data['Link'][0]['text']);
//                            $em->persist($tableCorrespondance);
//                            $em->flush();
//                        }
//                        $joueur->setNom($nomJoueur);
//                        $joueur->setRang($data['W20'][0]['text']);
//                        $joueur->setPoints($data['W50'][0]['text']);
////                $joueur->setRangMouvement($classement["ranking_movement"]);
////                $joueur->setTournoisJoue($classement["tournaments_played"]);
//
//                    }
//    //                    dump($joueur);
//                    $joueur->setNom($nomJoueur);
//                    $joueur->setRang($data['W20'][0]['text']);
//                    $joueur->setPoints($data['W50'][0]['text']);
//                    $em->persist($joueur);
//                    $em->flush();
//                }
//            }
//
//        }
//
//        die;
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats');//9 resultat sans cote
//        $api =file_get_contents('https://www.parionssport.fr/parisouverts/football');//9 resultat sans cote
//        $api =file_get_contents('https://www.parionssport.fr/api/competitions/1n2/100');//liste des competition nom + id
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/offre?sport=964500');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats?sport=100');//9 resultats ! sport 600 ne marche plus
//        $api =file_get_contents('https://www.parionssport.fr/api/combi-bonus/resultats');// beaucoup de resultat sur des pronostic pas de resultat precis
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats?sport=600'); //9 résultat sans cote trier par sport
//        $lastMaj =file_get_contents('https://www.parionssport.fr/api/date/last-update'); //dernière MAJ
        $api =file_get_contents('https://www.unibet.fr/zones/calendar/nextbets.json?limitHours=&from=07/02/2017&willBeLive=false&isOnPlayer=false'); //unibet
//        $api =file_get_contents('https://ls.betradar.com/ls/feeds/?/winamaxfr/fr/Africa:Lagos/gismo/event_get'); //winamax resultat
//        $api =file_get_contents('https://ls.betradar.com/ls/feeds/?/winamaxfr/fr/Africa:Lagos/gismo/bet_get/winamaxfr/0'); //winamax
//        $api =file_get_contents('https://ls.betradar.com/ls/feeds/?/winamaxfr/fr/Africa:Lagos/gismo/event_get'); //winamax resultat juste avec ID

        $jsonapi =  json_decode($api, true);
//        $jsonLastMaj =  json_decode($lastMaj, true);
//        var_dump($jsonapi[0]['formules'][0]['outcomes']);
//        var_dump($jsonLastMaj);
//          dump($jsonapi['doc'][0]['data'][6]); //winamax nom
//          dump($jsonapi['doc'][0]['data'][6]['match']['teams']); //winamax nom
//          dump($jsonapi['doc'][0]['data'][6]['match']['periods']); //winamax nom
//          dump($jsonapi['doc'][0]['data'][6]['match']['result']);//winamax result
//          dump($jsonapi['doc'][0]['data']);//winamax result
//        dump($jsonapi['doc'][0]['data'][0]);//result unibet
        dump($jsonapi[1]['selections']);//result unibet
//        dump($jsonapi['doc'][0]['data']);//result unibet


die;


        return $this->render('FdjBundle:Default:index.html.twig');
    }

    /**
     * @Route("/listeFoot", name="listeFoot")
     */
    public function listeFootAction()
    {
        $em = $this->getDoctrine()->getManager();
        $now = new \datetime();
        $startTxt = $now->format('Y-m-d') . ' 00:00:00';
        dump($startTxt);


        $matchs  = $em->getRepository('FdjBundle:Sport')->findByMatchAVenir($startTxt, '100');
//        dump($matchs);
//        die;
        $listeMatch = [];
        $listeMatchSaisie = [];
        foreach ($matchs as $key =>$match){
//            dump($key);
            $doublon = 0;
            if ($listeMatchSaisie == []){
                $listeMatch[$key]=$match;
                $listeMatchSaisie[$key]= $match;
//                dump($listeMatchSaisie);
            }else{
//                dump($listeMatchSaisie);
                $cleDoublon = 0;
                foreach ($listeMatchSaisie as $kee=>$item){
//                    dump($item);
                    if ($item->getLabel() == $match->getLabel()){
                        $doublon = 1;
//                    $keyPrecedente =
                        $matchDoublon = $item;
//                        dump($item);
                        $cleDoublon = $kee;
                    };
                }
                dump($doublon);
                dump($cleDoublon);
                if ($doublon == 0){
                    $listeMatchSaisie[$key]= $match;
                }else{
                    $listeMatchSaisie[$cleDoublon]= $match;
//                    $listeMatchSaisie[]
                }
                dump($listeMatchSaisie);
            }


        }

        return $this->render('FdjBundle:Default:listeMatchFoot.html.twig', array(
//            'matchs' => $matchs,
            'matchs' => $listeMatchSaisie,
        ));

    }

    /**
     * @Route("/analyseFoot{id}", name="analyseFoot")
     * @Method({"GET", "POST"})
     */
    public function analyseFootAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $match  = $em->getRepository('FdjBundle:Sport')->findOneById($id);
        dump($match->getEventId());
        $allParis  = $em->getRepository('FdjBundle:Sport')->findByEventId($match->getEventId());

        $listeMatch = [];
        $listeMatchSaisie = [];
        foreach ($allParis as $key =>$allPari){
//            dump($key);
            $doublon = 0;
            if ($listeMatchSaisie == []){
                $listeMatch[$key]=$allPari;
                $listeMatchSaisie[$key]= $allPari;
//                dump($listeMatchSaisie);
            }else{
//                dump($listeMatchSaisie);
                $cleDoublon = 0;
                foreach ($listeMatchSaisie as $kee=>$item){
//                    dump($item);
                    if ($item->getMarketType() == $allPari->getMarketType()){
                        $doublon = 1;
//                    $keyPrecedente =
                        $matchDoublon = $item;
//                        dump($item);
                        $cleDoublon = $kee;
                    };
                }
                if ($doublon == 0){
                    $listeMatchSaisie[$key]= $allPari;
                }else{
                    $listeMatchSaisie[$cleDoublon]= $allPari;
//                    $listeMatchSaisie[]
                }
            }
        }
        $allPariPourcentCote= [];
        $marketTypeId17 = [];
        $marketTypeId17Deux = [];
        $allParis = $listeMatchSaisie;
        foreach ($allParis as $key=>$allPari){
            $data['coteMin']= $allPari->getUn();
            $data['coteMax']= $allPari->getUn();
            $tennisCoteCumul17s = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,$allPari->getMarketTypeId());

            $win17 = $loose17 = $total17 = 0;
            foreach ($tennisCoteCumul17s as $coteCumul17){
                $marketTypeId17['win'] = $win17 + $coteCumul17->getWin();
                $marketTypeId17['loose'] = $loose17 + $coteCumul17->getloose();
                $marketTypeId17['total'] = $total17 + $coteCumul17->getWin() + $coteCumul17->getloose();
            }

            $data['coteMin']= $allPari->getDeux();
            $data['coteMax']= $allPari->getDeux();
            $tennisCoteCumul17sDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,17);
            dump($marketTypeId17);
            dump($tennisCoteCumul17sDeux);
            $win17 = $loose17 = $total17 = 0;

            foreach ($tennisCoteCumul17sDeux as $coteCumul17){
                $marketTypeId17Deux['win'] = $win17 + $coteCumul17->getWin();
                $marketTypeId17Deux['loose'] = $loose17 + $coteCumul17->getloose();
                $marketTypeId17Deux['total'] = $total17 + $coteCumul17->getWin() + $coteCumul17->getloose();
            }
            dump($marketTypeId17);
            dump($marketTypeId17Deux);
            if ($marketTypeId17 != [] && $marketTypeId17Deux != []){
                $allPariPourcentCote[$key]= (($marketTypeId17['win']+$marketTypeId17Deux['loose']) / ($marketTypeId17['total']+$marketTypeId17Deux['total']))*100;
            }elseif ($marketTypeId17 == [] && $marketTypeId17Deux == []){
                $allPariPourcentCote[$key]= [0];
            }elseif ($marketTypeId17 == []){
                $allPariPourcentCote[$key]= 100-(($marketTypeId17Deux['win']) / ($marketTypeId17Deux['total']))*100;
            }elseif ($marketTypeId17Deux == []){
                $allPariPourcentCote[$key]= (($marketTypeId17['win']) / ($marketTypeId17['total']))*100;
            }
            $allParis[$key]->setCoteCumul(round($allPariPourcentCote[$key],2));
        }
        dump($allPariPourcentCote);
        dump($allParis);
//        dump($allPariPourcentCote);
        //recuperer les cote des match + ou - grace a eventId

//----------------------------joueur1-----------------------------------------//
        $JNoms = explode("-", $match->getLabel());
        $J1Nom = $JNoms[0];
        $J2Nom = $JNoms[1];
//        dump($J1Nom);
//        dump($J2Nom);
        $j1Historiques = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findByNom($J1Nom);
        $j2Historiques = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findByNom($J2Nom);
        dump($j1Historiques);
//        dump($j2Historiques);
        $coteInitiale1 = str_replace(',', '.',$match->getUn());
        $minCote1 = $coteInitiale1 -0.1;
        $maxCote1 = $coteInitiale1 +0.1;
        $victoireCote1s = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findBycote($minCote1, $maxCote1);
        $calculVictoireCote1 = 0;
        $totalMatchJ1 =0;
        foreach ($victoireCote1s as $victoireCote1){
            $totalMatchJ1++;
//            dump($victoireCote1);
            if ($victoireCote1->getCote() >= $minCote1 && $victoireCote1->getCote() <= $maxCote1){
                if ($victoireCote1->getVictoire() == '1'){
                    $calculVictoireCote1++;
//                    dump($calculVictoireCote1);
                }
            }
        }
        if ($calculVictoireCote1 == 0){
            $txVictoireCote1 = 0;
        }else{
            $txVictoireCote1 = round($calculVictoireCote1/$totalMatchJ1*100);
        }
        $minCote1 = $minCote1 -0.1;
        $maxCote1 = $maxCote1 +0.1;
        $coteJ1HistoriqueTotal = 0;
        $coteJ1Historique = 0;
        foreach ($j1Historiques as $j1Historique){
            if ($j1Historique->getCote() >= $minCote1 && $j1Historique->getCote() <= $maxCote1){
                if ($j1Historique->getCote() >= $minCote1 && $j1Historique->getCote() <= $maxCote1) {
                    $coteJ1HistoriqueTotal++;
                    if ($j1Historique->getVictoire() == 1) {
                        $coteJ1Historique++;
                    }
                }
            }
        }
        if ($coteJ1Historique == 0){
            $coteJ1HistoriqueFinale = 0;
        }else{
            $coteJ1HistoriqueFinale = round($coteJ1Historique/$coteJ1HistoriqueTotal*100);
        }


//---------------------------------------------------------joueur2------------------------------------------------//
        $coteInitiale2 = str_replace(',', '.',$match->getDeux());
        $minCote2 = $coteInitiale2 -0.1;
        $maxCote2 = $coteInitiale2 +0.1;

        $victoireCote2s = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findBycote($minCote2, $maxCote2);
//        dump($victoireCote2s);
        $calculVictoireCote2 = 0;
        $totalMatchJ2 =0;
        foreach ($victoireCote2s as $victoireCote2){
            $totalMatchJ2++;
//            dump($victoireCote2);
            if ($victoireCote2->getCote() >= $minCote2 && $victoireCote2->getCote() <= $maxCote2){
                if ($victoireCote2->getVictoire() == '1'){
                    $calculVictoireCote2++;
//                    dump($calculVictoireCote2);
                }
            }
        }
        if ($calculVictoireCote2 == 0){
            $txVictoireCote2 = 0;
        }else{
            $txVictoireCote2 = round($calculVictoireCote2/$totalMatchJ2*100);
        }

        $minCote2 = $minCote2 -0.1;
        $maxCote2 = $maxCote2 +0.1;
        $coteJ2HistoriqueTotal = 0;
        $coteJ2Historique = 0;
        foreach ($j2Historiques as $j2Historique){
            if ($j2Historique->getCote() >= $minCote2 && $j2Historique->getCote() <= $maxCote2){
                $coteJ2HistoriqueTotal ++;
                if ($j2Historique->getVictoire() == 1){
                    $coteJ2Historique++;
                }

            }
        }
        if ($coteJ2Historique == 0){
            $coteJ2HistoriqueFinale = 0;
        }else{
            $coteJ2HistoriqueFinale = round($coteJ2Historique/$coteJ2HistoriqueTotal*100);
        }

        return $this->render('FdjBundle:Default:analyseFoot.html.twig', array(
            'JNoms' => $JNoms,
            'match' => $match,
            'j1Historiques' => $j1Historiques,
            'j2Historiques' => $j2Historiques,
            'txVictoireCote1' => $txVictoireCote1,
            'txVictoireCote2' => $txVictoireCote2,
            'totalMatchJ1' => $totalMatchJ1,
            'totalMatchJ2' => $totalMatchJ2,
            'coteJ1HistoriqueFinale' => $coteJ1HistoriqueFinale,
            'coteJ1HistoriqueTotal' => $coteJ1HistoriqueTotal,
            'coteJ2HistoriqueFinale' => $coteJ2HistoriqueFinale,
            'coteJ2HistoriqueTotal' => $coteJ2HistoriqueTotal,
            'allParis' => $allParis,
            'allPariPourcentCote'=> $allPariPourcentCote,
        ));
    }

    /**
     * @Route("/listeTennis", name="listeTennis")
     */
    public function listeTennisAction()
    {
        $em = $this->getDoctrine()->getManager();
        $now = new \datetime();
        $startTxt = $now->format('Y-m-d') . ' 00:00:00';
        dump($startTxt);
//        $startTxt = '2020-03-08 00:00:00';



        $matchs  = $em->getRepository('FdjBundle:Sport')->findByMatchAVenir($startTxt, '600');
//        dump($matchs);
//        die;
        $listeMatch = [];
        $listeMatchSaisie = [];
        foreach ($matchs as $key =>$match){
//            dump($key);
            $doublon = 0;
            if ($listeMatchSaisie == []){
                $listeMatch[$key]=$match;
                $listeMatchSaisie[$key]= $match;
//                dump($listeMatchSaisie);
            }else{
//                dump($listeMatchSaisie);
                $cleDoublon = 0;
                foreach ($listeMatchSaisie as $kee=>$item){
//                    dump($item);
                    if ($item->getLabel() == $match->getLabel()){
                        $doublon = 1;
//                    $keyPrecedente =
                        $matchDoublon = $item;
//                        dump($item);
                        $cleDoublon = $kee;
                    };
                }
                dump($doublon);
                dump($cleDoublon);
                if ($doublon == 0){
                    $listeMatchSaisie[$key]= $match;
                }else{
                    $listeMatchSaisie[$cleDoublon]= $match;
//                    $listeMatchSaisie[]
                }
                dump($listeMatchSaisie);
            }
            

        }

        return $this->render('FdjBundle:Default:listeMatchTennis.html.twig', array(
//            'matchs' => $matchs,
            'matchs' => $listeMatchSaisie,
        ));

    }

    /**
     * @Route("/analyseTennis{id}", name="analyseTennis")
     * @Method({"GET", "POST"})
     */
    public function analyseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $match  = $em->getRepository('FdjBundle:Sport')->findOneById($id);
        dump($match->getEventId());
        $allParis  = $em->getRepository('FdjBundle:Sport')->findByEventId($match->getEventId());

        $listeMatch = [];
        $listeMatchSaisie = [];
        foreach ($allParis as $key =>$allPari){
//            dump($key);
            $doublon = 0;
            if ($listeMatchSaisie == []){
                $listeMatch[$key]=$allPari;
                $listeMatchSaisie[$key]= $allPari;
//                dump($listeMatchSaisie);
            }else{
//                dump($listeMatchSaisie);
                $cleDoublon = 0;
                foreach ($listeMatchSaisie as $kee=>$item){
//                    dump($item);
                    if ($item->getMarketType() == $allPari->getMarketType()){
                        $doublon = 1;
//                    $keyPrecedente =
                        $matchDoublon = $item;
//                        dump($item);
                        $cleDoublon = $kee;
                    };
                }
                if ($doublon == 0){
                    $listeMatchSaisie[$key]= $allPari;
                }else{
                    $listeMatchSaisie[$cleDoublon]= $allPari;
//                    $listeMatchSaisie[]
                }
            }
        }
        $allPariPourcentCote= [];
        $marketTypeId17 = [];
        $marketTypeId17Deux = [];
        $allParis = $listeMatchSaisie;
        foreach ($allParis as $key=>$allPari){
            dump($allPari);
            $data['coteMin']= $allPari->getUn();
            $data['coteMax']= $allPari->getUn();
            $tennisCoteCumul17s = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,$allPari->getMarketTypeId());
            $win17 = $loose17 = $total17 = 0;
            $marketTypeId17 = [];
            foreach ($tennisCoteCumul17s as $coteCumul17){
                $marketTypeId17['win'] = $win17 + $coteCumul17->getWin();
                $marketTypeId17['loose'] = $loose17 + $coteCumul17->getloose();
                $marketTypeId17['total'] = $total17 + $coteCumul17->getWin() + $coteCumul17->getloose();
            }

            $data['coteMin']= $allPari->getDeux();
            $data['coteMax']= $allPari->getDeux();
            dump($allPari->getMarketTypeId());
            $tennisCoteCumul17sDeux = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,$allPari->getMarketTypeId());

            $win17 = $loose17 = $total17 = 0;
            $marketTypeId17Deux =[];
            foreach ($tennisCoteCumul17sDeux as $coteCumul17){
                $marketTypeId17Deux['win'] = $win17 + $coteCumul17->getWin();
                $marketTypeId17Deux['loose'] = $loose17 + $coteCumul17->getloose();
                $marketTypeId17Deux['total'] = $total17 + $coteCumul17->getWin() + $coteCumul17->getloose();
            }
            if ($marketTypeId17 != [] && $marketTypeId17Deux != []){
                $allPariPourcentCote[$key]= (($marketTypeId17['win']+$marketTypeId17Deux['loose']) / ($marketTypeId17['total']+$marketTypeId17Deux['total']))*100;
                dump($tennisCoteCumul17s);
                dump($tennisCoteCumul17sDeux);
            }elseif ($marketTypeId17 == [] && $marketTypeId17Deux == []){
                $allPariPourcentCote[$key]= 'sup';
                dump($allPari);
                dump($tennisCoteCumul17s);
                dump($tennisCoteCumul17sDeux);
            }elseif ($marketTypeId17 == []){
                $allPariPourcentCote[$key]= 100-(($marketTypeId17Deux['win']) / ($marketTypeId17Deux['total']))*100;
                dump($tennisCoteCumul17s);
                dump($tennisCoteCumul17sDeux);
            }elseif ($marketTypeId17Deux == []){
                $allPariPourcentCote[$key]= (($marketTypeId17['win']) / ($marketTypeId17['total']))*100;
                dump($tennisCoteCumul17s);
                dump($tennisCoteCumul17sDeux);
            }
            $allParis[$key]->setCoteCumul(round($allPariPourcentCote[$key],2));
        }
        dump($allPariPourcentCote);
        dump($allParis);
//        dump($allPariPourcentCote);
        //recuperer les cote des match + ou - grace a eventId

//----------------------------joueur1-----------------------------------------//
        $JNoms = explode("-", $match->getLabel());
        $J1Nom = $JNoms[0];
        $J2Nom = $JNoms[1];
//        dump($J1Nom);
//        dump($J2Nom);
        $j1Historiques = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findByNom($J1Nom);
        $j2Historiques = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findByNom($J2Nom);
        dump($j1Historiques);
//        dump($j2Historiques);
        $coteInitiale1 = str_replace(',', '.',$match->getUn());
        $minCote1 = $coteInitiale1 -0.1;
        $maxCote1 = $coteInitiale1 +0.1;
        $victoireCote1s = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findBycote($minCote1, $maxCote1);
        $calculVictoireCote1 = 0;
        $totalMatchJ1 =0;
        foreach ($victoireCote1s as $victoireCote1){
            $totalMatchJ1++;
//            dump($victoireCote1);
            if ($victoireCote1->getCote() >= $minCote1 && $victoireCote1->getCote() <= $maxCote1){
                if ($victoireCote1->getVictoire() == '1'){
                    $calculVictoireCote1++;
//                    dump($calculVictoireCote1);
                }
            }
        }
        if ($calculVictoireCote1 == 0){
            $txVictoireCote1 = 0;
        }else{
            $txVictoireCote1 = round($calculVictoireCote1/$totalMatchJ1*100);
        }
        $minCote1 = $minCote1 -0.1;
        $maxCote1 = $maxCote1 +0.1;
        $coteJ1HistoriqueTotal = 0;
        $coteJ1Historique = 0;
        foreach ($j1Historiques as $j1Historique){
            if ($j1Historique->getCote() >= $minCote1 && $j1Historique->getCote() <= $maxCote1){
                if ($j1Historique->getCote() >= $minCote1 && $j1Historique->getCote() <= $maxCote1) {
                    $coteJ1HistoriqueTotal++;
                    if ($j1Historique->getVictoire() == 1) {
                        $coteJ1Historique++;
                    }
                }
            }
        }
        if ($coteJ1Historique == 0){
            $coteJ1HistoriqueFinale = 0;
        }else{
            $coteJ1HistoriqueFinale = round($coteJ1Historique/$coteJ1HistoriqueTotal*100);
        }


//---------------------------------------------------------joueur2------------------------------------------------//
        $coteInitiale2 = str_replace(',', '.',$match->getDeux());
        $minCote2 = $coteInitiale2 -0.1;
        $maxCote2 = $coteInitiale2 +0.1;

        $victoireCote2s = $em->getRepository('FdjBundle:JoueurTennisScoreCote')->findBycote($minCote2, $maxCote2);
//        dump($victoireCote2s);
        $calculVictoireCote2 = 0;
        $totalMatchJ2 =0;
        foreach ($victoireCote2s as $victoireCote2){
            $totalMatchJ2++;
//            dump($victoireCote2);
            if ($victoireCote2->getCote() >= $minCote2 && $victoireCote2->getCote() <= $maxCote2){
                if ($victoireCote2->getVictoire() == '1'){
                    $calculVictoireCote2++;
//                    dump($calculVictoireCote2);
                }
            }
        }
        if ($calculVictoireCote2 == 0){
            $txVictoireCote2 = 0;
        }else{
            $txVictoireCote2 = round($calculVictoireCote2/$totalMatchJ2*100);
        }

        $minCote2 = $minCote2 -0.1;
        $maxCote2 = $maxCote2 +0.1;
        $coteJ2HistoriqueTotal = 0;
        $coteJ2Historique = 0;
        foreach ($j2Historiques as $j2Historique){
            if ($j2Historique->getCote() >= $minCote2 && $j2Historique->getCote() <= $maxCote2){
                $coteJ2HistoriqueTotal ++;
                if ($j2Historique->getVictoire() == 1){
                    $coteJ2Historique++;
                }

            }
        }
        if ($coteJ2Historique == 0){
            $coteJ2HistoriqueFinale = 0;
        }else{
            $coteJ2HistoriqueFinale = round($coteJ2Historique/$coteJ2HistoriqueTotal*100);
        }

        return $this->render('FdjBundle:Default:analyseTennis.html.twig', array(
            'JNoms' => $JNoms,
            'match' => $match,
            'j1Historiques' => $j1Historiques,
            'j2Historiques' => $j2Historiques,
            'txVictoireCote1' => $txVictoireCote1,
            'txVictoireCote2' => $txVictoireCote2,
            'totalMatchJ1' => $totalMatchJ1,
            'totalMatchJ2' => $totalMatchJ2,
            'coteJ1HistoriqueFinale' => $coteJ1HistoriqueFinale,
            'coteJ1HistoriqueTotal' => $coteJ1HistoriqueTotal,
            'coteJ2HistoriqueFinale' => $coteJ2HistoriqueFinale,
            'coteJ2HistoriqueTotal' => $coteJ2HistoriqueTotal,
            'allParis' => $allParis,
            'allPariPourcentCote'=> $allPariPourcentCote,
        ));
    }

    /**
     * @Route("/preuveDeConceptBdd", name="preuveDeConceptBdd")
     */
    public function PreuveDeConceptBddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cote = 1.25;
        $txReussite = 76;
        $marge = 1;
        $palierPerdant = 4;
        $coffreIncrementCase = 4;
        $win = $loose = $palier = $caseActuelleDuCoffre = $HistoriqueNbParisPourBoucle = $nbParisPourBoucle =0;
        $coffreDePertes = [];
        $perte = $perteTotale = $solde = $perteMax = $soldeMinHisto = $miseMaxHisto = $mise = $testMeilleurParametre =0;
        //-------------Test------------//
//        for ($a = 1; $a < 2; $a++) {
//            $palierPerdant = $a;
            $win = $loose = $palier = $caseActuelleDuCoffre =0;
            $coffreDePertes = [];
            $perte = $perteTotale = $solde = $perteMax = $mise =0;
            //--------Algoritme------------//

            for ($i = 0; $i < 1000; $i++) {
                $nbParisPourBoucle++;
//                    if ($perteMax > 10000){
////                        dump('PERTE MAX : '.$perteMax.'---------------------------/');
//                        $i = 5000000;
//                        $stop = 1;
//                    }
                dump('------------NV Paris -----------------------');
                dump('Paris n°' . ($i + 1));

                if ($coffreDePertes == []) {
                    $mise = round($marge / ($cote - 1), 2);
                } else {
                    $mise = round(($coffreDePertes[0]['perte'] + $marge) / ($cote - 1), 2);
                }
                $solde = $solde - $mise;
                dump('mise : ' . $mise);
                $tirage = rand(1, 100);
                if ($tirage <= $txReussite) {
                    $resultat = 1;
                } else {
                    $resultat = 2;
                }
                if ($resultat == 1) {
                    dump('----------------GAGNANT-------------------------- : ');
                    $win++;
                } else {
                    $loose++;
                    dump('----------------PERDANT-------------------------- : ');
                }

                if ($resultat == 2) { //perdant//
                    if ($coffreDePertes == []) {
                        dump('p$coffreDePertes == []');
                        $nbParisPourBoucle = 0;
                        for ($r = 0; $r < 3; $r++) {
                            $coffreDePertes[$r] = ['perte' => ($mise + $marge) / 3, 'palier' => 2];
                        }

                    } else {
                        $perte = $case = 0;
                        foreach ($coffreDePertes as $coffreDePerte) {
                            $perte = $perte + $coffreDePerte['perte'];

                        }
                        $palier = $coffreDePertes[0]['palier'];
//                        if ($palier < $palierPerdant){
//                            $palier ++;
//                            $coffreDePertes[0]['palier']= $palier;
//                        }else{
                        $palier++;
                        $perte = $perte + $mise + $marge;
                        dump($perte);
                        $case = round($perte/20);//5€parcase
                        dump($case);
                        if($case < 1){
                            $case = 1;
                        }elseif ($case >20){
                            $case = 20;
                        }
                        $coffreDePertes = [];
                        for ($b = 0; $b < $case; $b++) {
                                $coffreDePertes[$b] = ['perte' => ($perte / $case), 'palier' => 1];
//                            }
                        }

                    }
                } else {// Gagnant //
                    $solde = $solde + $mise * $cote;
                    if ($coffreDePertes == []) {
                        dump('G$coffreDePertes == []');
                        $nbParisPourBoucle = 0;
                    } else {
                        $case = 0;
                        foreach ($coffreDePertes as $coffreDePerte) {
                            $case++;
                        }
                        dump($case);
                        if ($case == 1) {
                            $coffreDePertes = [];

                        } else {
                            $case = $case - 1;
                            $perte = $coffreDePertes[0]['perte'];
                            $coffreDePertes = [];
                            for ($b = 0; $b < $case; $b++) {
                                $coffreDePertes[$b] = ['perte' => $perte, 'palier' => 1];
                            }
                        }


                    }

                }
                if ($nbParisPourBoucle > $HistoriqueNbParisPourBoucle) {
                    $HistoriqueNbParisPourBoucle = $nbParisPourBoucle;
                }
                dump('coffre de perte : ');
                dump($coffreDePertes);
                dump('solde : ' . $solde);
                if ($soldeMinHisto > $solde) {
                    $soldeMinHisto = $solde;
                }
                Dump('solde : ' . $solde);
                dump('victoire :' . $win . ', defaite : ' . $loose);
                dump('soldeMin : ' . $soldeMinHisto);
                dump('mise max : ' . $miseMaxHisto);
                dump('Nombre de paris pour cloturer la boucle : ' . $HistoriqueNbParisPourBoucle);
                if ($testMeilleurParametre == 0) {
                    $testMeilleurParametre = $soldeMinHisto;
                    $testResult = 'SoldeMin : ' . $soldeMinHisto . ', palierPerdant : ' . $palierPerdant . ', coffreIncrementCase : ' . $coffreIncrementCase;
                } elseif ($testMeilleurParametre > $soldeMinHisto) {
                    $testMeilleurParametre = $soldeMinHisto;
                    $testResult = 'SoldeMin : ' . $soldeMinHisto . ', palierPerdant : ' . $palierPerdant . ', coffreIncrementCase : ' . $coffreIncrementCase;
                }
                dump($testResult);
//            }
            }

        die;


        $cote = 1.35;
        $txReussite = 67;
        $marge = 1;
        $palierPerdant = 4;
        $coffreIncrementCase = 4;
        $win = $loose = $palier = $caseActuelleDuCoffre =0;
        $coffreDePerte = 0;
        $perte = $perteTotale = $solde = $perteMax = $soldeMinHisto = $miseMaxHisto =0;
        $testMeilleurParametre = 0;
        $palierEuroCoffreMax = 50;
        //-------------Test------------//
        for ($a = 5; $a < 6; $a++) {
            $palierPerdant = $a;
//            if ($a ==2){
//                $b = 9;
//            }else{
//                $b=2;
//            }
            for ($b=4; $b < 5; $b++) {

                $perte = $perteTotale = $solde = $perteMax = $soldeMinHisto = $miseMaxHisto =0;
                $win = $loose = $palier = $caseActuelleDuCoffre = $nbParisPourBoucle = $HistoriqueNbParisPourBoucle = $decalage = $HistoriqueDecalage =0;
                $algoMiseTabs = [];
                dump('//-----------Reinitialisation----------/');
                $coffreIncrementCase = $b;
                dump('palierPerdant : '.$palierPerdant);
                dump('coffreIncrementCase : '.$coffreIncrementCase);
//                foreach ($algoMises as $algoMise){
//                    $em->remove($algoMise);
//                    $em->flush();
//                }
                //--------Algoritme------------//
                $stop = 0;
                for ($i = 0; $i < 1000; $i++) {
                    $nbParisPourBoucle++;
                    if ($perteMax > 10000){
                        dump('PERTE MAX : '.$perteMax.'---------------------------/');
                        $i = 5000000;
                        $stop = 1;
                    }
//                    $algoMises = $em->getRepository('FdjBundle:AlgoMise')->findByAlgoMise('joel');
            dump('------------NV Paris -----------------------');
            dump('Paris n°'.($i+1));
                    if ($algoMiseTabs == []){
                        $perte = 0;
                    }else {
//                        dump($algoMiseTabs);
                        $perte = $algoMiseTabs[0]['perte'];
                    }
                    $tirage = rand(1, 100);
                    if ($tirage <= $txReussite) {
                        $resultat = 1;
                    } else {
                        $resultat = 2;
                    }
                    if ($resultat == 1) {
                        $win++;
                        $decalage --;
                        if ($decalage < 0){
                            $decalage = 0;
                        }
                dump('----------------GAGNANT-------------------------- : ');
                    } else {
                        $loose++;
                        $decalage ++;
                dump('----------------PERDANT-------------------------- : ');
                    }
//                    dump('decalage : '.$decalage);
                    dump('Decalage : ' . $decalage);
                    //-------Mise-----------------//
                    $mise = round(($perte + $marge) / ($cote - 1), 2);
            dump('mise : (' . $perte . ' + ' . $marge . ') / (' . $cote . '-1)');
            dump('mise : '.$mise);
                    $solde = $solde - $mise;
                    $perte = $perte + $mise + $marge;
                    $perteTotale = $perteTotale + $mise + $marge;
                    $perteMax = $perteMax + $mise;

                    if ($resultat == 2) { //perdant//
//                dump($algoMises);
                        if ($algoMiseTabs == []){
                            $nbParisPourBoucle = 0;
                            $algoMiseTabs[]=['perte'=>($mise+$marge),'palier'=>(2)];
//                            dump($algoMiseTabs);
                        }elseif ($algoMiseTabs[0]['palier'] < $palierPerdant){
                            $pertePalier = $algoMiseTabs[0]['perte'] + $mise + $marge;
                            if ($pertePalier > $palierEuroCoffreMax){
                                $newPerte = 0;
                                $nbCoffrePerte =0;
                                foreach ($algoMiseTabs as $algoPerte){
                                    $newPerte = $newPerte + $algoPerte['perte'];
                                    $nbCoffrePerte++;
                                }

                                $newPerte = $newPerte + $mise +$marge;
//                            dump('perteTotale : '.$newPerte);
//                            $nbCoffrePerte = $nbCoffrePerte + $coffreIncrementCase;
                                $nbCoffrePerte = $decalage - 2;
                                if ($nbCoffrePerte < 2){
                                    $nbCoffrePerte = 1;
                                }
                                if ($newPerte /$nbCoffrePerte > $palierEuroCoffreMax){
                                    $nbCoffrePerte = round($newPerte / $palierEuroCoffreMax);
                                }
                                $algoMiseTabs = [];
                                for ($k =0; $k < $nbCoffrePerte; $k++ ){
                                    $algoMiseTabs[$k]=['perte'=> ($newPerte / $nbCoffrePerte), 'palier'=> 1];

                                }
                            }else{
                                $algoMiseTabs[0] = ['perte'=>$pertePalier, 'palier'=>($algoMiseTabs[0]['palier'] + 1)];
                            }
//                            dump($algoMiseTabs);
                        }elseif ($algoMiseTabs[0]['palier'] == $palierPerdant){
//                    $perte = $algoMises[0]->getPerte() + $mise + $marge;
                            $newPerte = 0;
                            $nbCoffrePerte =0;
                            foreach ($algoMiseTabs as $algoPerte){
                                $newPerte = $newPerte + $algoPerte['perte'];
                                $nbCoffrePerte++;
                            }

                            $newPerte = $newPerte + $mise +$marge;
//                            dump('perteTotale : '.$newPerte);
//                            $nbCoffrePerte = $nbCoffrePerte + $coffreIncrementCase;
                            $nbCoffrePerte = $decalage - 2;
                            if ($nbCoffrePerte < 2){
                                $nbCoffrePerte = 1;
                            }
                            if ($newPerte /$nbCoffrePerte > $palierEuroCoffreMax){
                                $nbCoffrePerte = round($newPerte / $palierEuroCoffreMax);
                            }
                            $algoMiseTabs = [];
                            for ($k =0; $k < $nbCoffrePerte; $k++ ){
                                $algoMiseTabs[$k]=['perte'=> ($newPerte / $nbCoffrePerte), 'palier'=> 1];

                            }
//                            $em->flush();


                        }
//                        $algoMises = $em->getRepository('FdjBundle:AlgoMise')->findByAlgoMise('joel');
                    }else {// Gagnant //
                        $solde = $solde + ($mise*$cote);
                        $perteMax = $perteMax - ($mise*$cote);
                        if ($perteMax < 0){
                            $perteMax = 0;
                        }
                        $newAlgoTabs = [];
                        if ($algoMiseTabs == []){

                        }else{
                            foreach ($algoMiseTabs as $key => $algoMiseTab){
                                if ($key == 0){

                                }else{
                                    $newAlgoTabs[$key-1] = $algoMiseTab;
                                }
                            }
                            $algoMiseTabs = $newAlgoTabs;
                        }

                    }
                    if ($soldeMinHisto < $perteMax) {
                        $soldeMinHisto = $perteMax;
                    }
                    if ($miseMaxHisto < $mise && $i != 5000000) {
                        $miseMaxHisto = $mise;
                    }
                    if ($nbParisPourBoucle > $HistoriqueNbParisPourBoucle){
                        $HistoriqueNbParisPourBoucle = $nbParisPourBoucle;
                    }
                    if ($decalage > $HistoriqueDecalage){
                        $HistoriqueDecalage = $decalage;
                    }

                    dump($algoMiseTabs);
                    dump('solde : '.$solde);
                    dump('soldeMin : '.$soldeMinHisto);
                    dump('victoire :' . $win . ', defaite : ' . $loose);

                }
                if ($stop ==0) {
                    Dump('solde : ' . $solde);
                    dump('victoire :' . $win . ', defaite : ' . $loose);
                    dump('Decalage : ' . $decalage);
                    dump('soldeMin : ' . $soldeMinHisto);
                    dump('mise max : ' . $miseMaxHisto);
                    dump('Nombre de paris pour cloturer la boucle : ' . $HistoriqueNbParisPourBoucle);
                    if ($testMeilleurParametre == 0) {
                        $testMeilleurParametre = $soldeMinHisto;
                        $testResult = 'SoldeMin : ' . $soldeMinHisto . ', palierPerdant : ' . $palierPerdant . ', coffreIncrementCase : ' . $coffreIncrementCase;
                    } elseif ($testMeilleurParametre > $soldeMinHisto) {
                        $testMeilleurParametre = $soldeMinHisto;
                        $testResult = 'SoldeMin : ' . $soldeMinHisto . ', palierPerdant : ' . $palierPerdant . ', coffreIncrementCase : ' . $coffreIncrementCase;
                    }
                    dump($testResult);
                }
            }
        }
        dump($testResult);





        die;


        $algoMises = $em->getRepository('FdjBundle:AlgoMise')->findByAlgoMise('joel');
        foreach ($algoMises as $algoMise){
            $em->remove($algoMise);
            $em->flush();
        }
        $cote = 1.7;
        $txReussite = 50;
        $marge = 1;
        $palierPerdant = 2;
        $coffreIncrementCase = 3;
        $win = $loose = $palier = $caseActuelleDuCoffre =0;
        $coffreDePerte = 0;
        $perte = $perteTotale = $solde = $perteMax = $soldeMinHisto = $miseMaxHisto =0;

        //--------Algoritme------------//
        for ($i = 0; $i < 100; $i++) {
            $algoMises = $em->getRepository('FdjBundle:AlgoMise')->findByAlgoMise('joel');
            dump('------------NV Paris -----------------------');
            dump('Paris n°'.($i+1));
            if ($algoMises == []){
                $perte = 0;
            }else {
                $perte = $algoMises[0]->getPerte();
            }
            $tirage = rand(1, 100);
            if ($tirage <= $txReussite) {
                $resultat = 1;
            } else {
                $resultat = 2;
            }
            if ($resultat == 1) {
                $win++;
                dump('----------------GAGNANT-------------------------- : ');
            } else {
                $loose++;
                dump('----------------PERDANT-------------------------- : ');
            }

            //-------Mise-----------------//
            $mise = round(($perte + $marge) / ($cote - 1), 2);
            dump('mise : (' . $perte . ' + ' . $marge . ') / (' . $cote . '-1)');
            dump('mise : '.$mise);
            $solde = $solde - $mise;
            $perte = $perte + $mise + $marge;
            $perteTotale = $perteTotale + $mise + $marge;
            $perteMax = $perteMax + $mise;

            if ($resultat == 2) { //perdant//
                dump($algoMises);
                if ($algoMises == []){
                    $algoMise = new AlgoMise();
                    $algoMise->setUtilisateur('joel');
                    $algoMise->setPerte($mise+$marge);
                    $algoMise->setPalier(2);
                    $algoMise->setStart(0);
                    $em->persist($algoMise);
                    $em->flush();
                }elseif ($algoMises[0]->getPalier() < $palierPerdant){
                    $algoMises[0]->setPerte($algoMises[0]->getPerte() + $mise + $marge);
                    $algoMises[0]->setPalier($algoMises[0]->getPalier() + 1);
                    $em->persist($algoMises[0]);
                    $em->flush();
                }elseif ($algoMises[0]->getPalier() == $palierPerdant){
//                    $perte = $algoMises[0]->getPerte() + $mise + $marge;
                    $newPerte = 0;
                    $nbCoffrePerte =0;
                    foreach ($algoMises as $algoPerte){
                        $newPerte = $newPerte + $algoPerte->getPerte();
                        $nbCoffrePerte++;
                    }
                    $newPerte = $newPerte + $mise +$marge;
                    dump('perteTotale : '.$newPerte);
                    $nbCoffrePerte = $nbCoffrePerte + $coffreIncrementCase;
                    foreach ($algoMises as $algoMise){
                        $em->remove($algoMise);
                        $em->flush();
                    }
                    for ($k =0; $k < $nbCoffrePerte; $k++ ){
                        $algoMise = new AlgoMise();
                        $algoMise->setUtilisateur('joel');
                        $algoMise->setPerte($newPerte / $nbCoffrePerte);
                        $algoMise->setPalier(1);
                        $algoMise->setStart(0);
                        $em->persist($algoMise);
                        $em->flush();
                    }

//                    $algoMises[0]->setPerte($newPerte);
////                    $algoMises[0]->setPerte($perte/$coffreIncrementCase);
//                    $algoMises[0]->setPalier(1);
//                    $em->persist($algoMises[0]);
//                    $em->flush();
//                    for ($j=1; $j < $coffreIncrementCase; $j++){
//                        $algoMise = new AlgoMise();
//                        $algoMise->setUtilisateur('joel');
//                        $algoMise->setPerte($newPerte);
////                        $algoMise->setPerte($perte/$coffreIncrementCase);
//                        $algoMise->setPalier(1);
//                        $algoMise->setStart(0);
//                        $em->persist($algoMise);
//                        $em->flush();
//                    }

                }
                $algoMises = $em->getRepository('FdjBundle:AlgoMise')->findByAlgoMise('joel');
            }else {// Gagnant //
                $solde = $solde + ($mise*$cote);
                $perteMax = $perteMax - ($mise*$cote);
                if ($perteMax < 0){
                    $perteMax = 0;
                }
                if ($algoMises == []){

                }else{
                    $em->remove($algoMises[0]);
                    $em->flush();
                }

            }
            if ($soldeMinHisto < $perteMax) {
                $soldeMinHisto = $perteMax;
            }
            if ($miseMaxHisto < $mise) {
                $miseMaxHisto = $mise;
            }
            dump($algoMises);
            dump('solde : '.$solde);
        }

        dump('victoire :'.$win.', defaite : '.$loose);
        dump('soldeMin : '.$soldeMinHisto);
        dump('mise max : '.$miseMaxHisto);




        die;
    }


    /**
     * @Route("/preuveDeConcept", name="preuveDeConcept")
     */
    public function PreuveDeConceptAction(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
        //------------initialisation des variables -----------------------//
        $cote = 1.7;
        $txReussite = 50;
        $marge = 1;
        $palierPerdant = 5;
        $coffreNbCase = 20;
        $win = $loose = $suitePerdant = $caseActuelleDuCoffre =0;
        $coffreDePerte = 0;
        $perte = $perteTotale = $solde = $perteMax = $soldeMinHisto =0;

        //--------Algoritme------------//
        for ($i = 0; $i < 2000; $i++) {  //-----------------------------------------------------------------activer pour prod-------------///
            dump('------------NV Paris -----------------------');
            dump('Debut : perteTotale : '.$perteTotale);
            $tirage = rand(1, 100);  //-----------------------------------------------------------------activer pour prod ------------//
            if ($tirage <= $txReussite) {
                $resultat = 1;
            }else {
                $resultat = 2;
            }
            if ($resultat == 1) {
                $win++;
                dump('----------------GAGNANT-------------------------- : ');
            } else {
                $loose++;
                dump('----------------PERDANT-------------------------- : ');
            }

            //-------Mise-----------------//
            $mise = round(($perte + $marge) / ($cote-1),2);
            dump('mise : ('.$perte.' + '.$marge.') / ('.$cote.'-1)');
            dump('mise : round(($perte + $marge) / ($cote-1),2)');
            $solde = $solde - $mise;
            $perte = $perte + $mise + $marge;
            $perteTotale = $perteTotale + $mise + $marge;
            $perteMax = $perteMax + $mise;

//            $historique[$i] = $resultat;
            //---------- calcul resultat ------------//
            // Perdant //
            if ($resultat == 2) {
                $suitePerdant ++;
                if ($suitePerdant >= $palierPerdant) {
                    dump('Perdant : $suitePerdant > $palierPerdant');
                    if ($coffreDePerte == 0) {
                        $perte = $perteTotale/$coffreNbCase;
                        $perteTotale = $perteTotale -$perte;
                        $coffreDePerte = [];
                        for ($j = 0; $j < $coffreNbCase; $j++) {
                            $coffreDePerte[$j] = $perte; //-----------------------------ajouter le montant au maument du set de la mise-----------//
                        }
                    } else {

//                        $perteTotale = $perteTotale -$perte;
                        $perteTotale = $coffreDePerte[$coffreNbCase-1] * ($coffreNbCase - $caseActuelleDuCoffre);
                        $perte = ($perteTotale+$perte)/$coffreNbCase;
                        $coffreDePerte = [];
                        for ($j = 0; $j < $coffreNbCase; $j++) {
                            $coffreDePerte[$j] = $perte; //-----------------------------ajouter le montant au maument du set de la mise-----------//
                        }
                    }
                    $suitePerdant = 0;
                    $caseActuelleDuCoffre = 1;
                }
            }else {// Gagnant //
                $perteMax = $perteMax - ($mise *$cote);
                if ($perteMax < 0 ){
                    $perteMax = 0;
                }
                if ($coffreDePerte != 0){
                    $perte = $coffreDePerte[$caseActuelleDuCoffre-1];
                }else{
                    $perte = round($perte - ($mise * $cote),2);
                }

                $solde = round($solde + ($mise *$cote),2);
                if ($perte < 0){
                    $perte = 0;
                }
                $perteTotale = $perteTotale - ($mise * $cote);
                if ($perteTotale < 0){
                    $perteTotale = 0;
                }
                if ($coffreDePerte != 0) {
                    if ($caseActuelleDuCoffre < $coffreNbCase) {
                        $caseActuelleDuCoffre++;
                    } else {
                        $caseActuelleDuCoffre = 0;
                        $coffreDePerte = 0;
                        $perte = $perteTotale = 0;
                    }
                }
                $suitePerdant = 0;
            }
            if ($soldeMinHisto < $perteMax) {
                $soldeMinHisto = $perteMax;
            }
            dump('mise : '.$mise);
            dump('perte : '.$perte);
            dump('solde : '.$solde.'€');
            dump('perteTotale : '.$perteTotale);
            dump('suitePerdant : '.$suitePerdant);
            dump('caseActuelleDuCoffre : '.$caseActuelleDuCoffre);
            dump('coffreDePerte : ');
            dump($coffreDePerte);
            dump('victoire :'.$win.', defaite : '.$loose);
            dump('soldeMin : '.$soldeMinHisto);
        }
        die;
    }

    //------------initialisation des variables -----------------------//
//$cote = 1.7;
//$txReussite = 50;
//$marge = 1;
//$palier = 1;
//$initialMise = 1;
//$seuilMontantChangementNiveau = 4000;
//$nbPalierChangementNiveau = 20;
//$perte = $perteTotal = $perteTotalNiveau = $niveauMontant = $niveauEnCours  = $serieTotal = $mise = 0;
//$test = 1;
//$perteHistorique = 0;
//$historiquePerteTotalNiveau = [];
//$solde = $soldeMinHisto = 0;
//$win = $loose = $miseMax = 0;
//
//    //--------Algoritme------------//
////        $resultats = [1,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,2,1,1,2,1,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
////        foreach ($resultats as $resultat){
//$historique = [];
//for ($i = 0; $i < 100; $i++) {  //-----------------------------------------------------------------activer pour prod-------------///
//    //--------Etude du niveau ----------//
//if ($niveauEnCours != 0) {
//$index = $niveauEnCours - 1;
//$niveauMontant = $perteTotalNiveau[$index];
//}
//dump('New paris---------------------------------------------//');
////            dump('Resultat : ' . $resultat);
//dump('niveau en cours : ' . $niveauEnCours);
//dump('perte : ' . $perte);
//dump('perteTotale : ' . $perteTotal);
//dump('mise initiale : ' . $initialMise);
////-----------Calcul de la mise --------------//
//$mise = round(($marge + ($perteTotal / $palier)) / ($cote - 1), 2, PHP_ROUND_HALF_UP);
////            dump('CalculMise : ('.$marge.' + ('.$niveauMontant.'/'.$palier.') + ('.$perteTotal.'/'.$palier.'))/'.$cote.'-1');
//dump('CalculMise : (' . $marge . ' + (' . $perteTotal . '/' . $palier . '))/' . $cote . '-1');
//$solde = $solde - $mise;
//dump('mise : ' . $mise);
////------------- Generation auto des victoires 1 /defaites 2 --------------//
//$tirage = rand(1, 100);  //-----------------------------------------------------------------activer pour prod ------------//
//if ($tirage <= $txReussite) {
//    $resultat = 1;
//} else {
//    $resultat = 2;
//}
//if ($resultat == 1) {
//    $win++;
//} else {
//    $loose++;
//}
////            $historique[$i] = $resultat;
//dump('resueltat : ' . $resultat);
//
////---------- calcul resultat ------------//
//// Perdant //
//if ($resultat == 2) {
//    dump('perdant');
//    $perte = $perte + $mise + $marge;
//    dump('paris perdant, perte : ' . $perte);
//    if ($perte > ($marge * $seuilMontantChangementNiveau)) {
//        dump('paris perdant, niveau en cours : ' . $niveauEnCours);
//        if ($perteTotalNiveau == 0) {
//            $perteTotalNiveau = [];
//            for ($j = 0; $j < $nbPalierChangementNiveau; $j++) {
//                $perteTotalNiveau[$j] = $perte / $nbPalierChangementNiveau;
////                            array_push($perteTotalNiveau,  $perte/$nbPalierChangementNiveau);
//                $initialMise = 1;
//            }
//            dump('Set 1erNiveau, perteTotalNiveau : ');
//            dump($perteTotalNiveau);
//            $perteTotal = $perte = $perteTotalNiveau[0];
//            $niveauEnCours = 1;
//        } else {
//            $count = count($perteTotalNiveau);
//            $stopFor = $count + $nbPalierChangementNiveau;
//            for ($j = $count; $j < $stopFor; $j++) {
//                $perteTotalNiveau[$j] = $perte / $nbPalierChangementNiveau;
//                $initialMise = 1;
//            }
//            dump('Set NiveauComplementaire, perteTotalNiveau : ');
//            dump($perteTotalNiveau);
//            $perteTotal = $perte = $perteTotalNiveau[$index];
//            dump('Set 1erNiveau, perteTotalNiveau : ' . $perte);
//        }
//    } else {
//        dump('perte sans ajour de niveau');
//        $initialMise = 0;
//        if ($perte > $perteTotal) {
//            $perteTotal = $perte;
//        }
//    }
//    dump('perte, miseInitiale : ' . $initialMise);
//} elseif ($resultat == 1) {// Gagnant //
//    dump('gagnant');
//    $solde = $solde + ($mise * $cote);
//    if ($niveauEnCours == 0) {
//        dump('test IF $initialMise == 1');
//        $perteTotal = $perte = 0;
//        $initialMise = 0;
//        $count = count($perteTotalNiveau);
////                    if ($count == $niveauEnCours && $niveauEnCours != 0) {
////                        $niveauEnCours = 0;
////                        $perteTotalNiveau = 0;
////                        $niveauMontant = 0;
////                    }
//    } else {
//        dump('perte et mise initiale 0');
//        $count = count($perteTotalNiveau);
//        if ($count == $niveauEnCours) {
//            $niveauEnCours = 0;
//            $perteTotalNiveau = 0;
//            $niveauMontant = 0;
//        } elseif ($niveauEnCours > 0) {
//            $niveauEnCours++;
//            $perte = $perteTotal = $perteTotalNiveau[$niveauEnCours - 1];
//        }
//        $initialMise = 1;
//    }
////                } elseif ($serie < $palier) {
////                    dump('test IF $serie < $palier');
////                    $perte = $perte - ($mise * ($cote - 1));
////                }
//    dump('gagnant, miseInitiale : ' . $initialMise);
//}
//if ($perteHistorique < $perte) {
//    dump('testGlobal');
//    $perteHistorique = $perte;
//}
//$historiqueCount1 = count($perteTotalNiveau);
//$historiqueCount2 = count($historiquePerteTotalNiveau);
//if ($historiqueCount1 > $historiqueCount2) {
//    $historiquePerteTotalNiveau = $perteTotalNiveau;
//}
//dump('solde : ' . $solde);
//if ($solde < $soldeMinHisto) {
//    $soldeMinHisto = $solde;
//}
//if ($mise > $miseMax){
//    $miseMax = $mise;
//}
//}
//
//
////        dump($historique);
//dump('perteMax : ' . $perteHistorique);
//dump('maxPerteTotalNiveau');
//dump($historiquePerteTotalNiveau);
//dump('soldeTotal : ' . $solde);
//dump('soldeMinimum : ' . $soldeMinHisto);
//dump('victoire :' . $win . ', defaite : ' . $loose);
//dump('mise max : '.$miseMax);
//die;
//}

//multi
        //------------initialisation des variables -----------------------//
//        $cote = 1.7;
//        $txReussite = 50;
//        $marge =0.1;
//        $palier = 1;
//        $initialMise = 1;
//        $seuilMontantChangementNiveau = 800;
//        $nbPalierChangementNiveau = 20;
//        $perte = $perteTotal = $perteTotalNiveau= $niveauMontant = $niveauEnCours = $serie = $serieTotal = $mise = 0;
//        $test = 1;
//        $perteHistorique = 0;
//        $historiquePerteTotalNiveau = [];
//        $solde = $soldeMinHisto = 0;
//        $win = $loose =0;
//
//        //--------Algoritme------------//
////        $resultats = [1,2,2,2,2,2,2,2,2,2,2,1,1,2,2,2,2,2,2,1,1,2,1,1,2,1,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
////        foreach ($resultats as $resultat){
//        $historique = [];
//        for ($i=0; $i<500; $i++){  //-----------------------------------------------------------------activer pour prod-------------///
//            //--------Etude du niveau ----------//
//            if ($niveauEnCours != 0){
//                $index = $niveauEnCours -1;
//                $niveauMontant = $perteTotalNiveau[$index];
//            }
//            dump('New paris---------------------------------------------//');
////            dump('Resultat : ' . $resultat);
//            dump('niveau en cours : '. $niveauEnCours);
//            dump('perte : '.$perte);
//            dump('perteTotale : '.$perteTotal);
//            dump('mise initiale : '. $initialMise);
//            dump('serie : '.$serie);
//            //-----------Calcul de la mise --------------//
//            if ($serie == 0){
//                $mise = round(($marge  + ($perteTotal/ $palier))/($cote -1),2,PHP_ROUND_HALF_UP);
//            } else {
//                $mise = round(($marge + ($perteTotal/ $palier))/($cote -1),2,PHP_ROUND_HALF_UP);
//            }
////            dump('CalculMise : ('.$marge.' + ('.$niveauMontant.'/'.$palier.') + ('.$perteTotal.'/'.$palier.'))/'.$cote.'-1');
//            dump('CalculMise : ('.$marge.' + ('.$perteTotal.'/'.$palier.'))/'.$cote.'-1');
//            $solde = $solde - $mise;
//            dump('mise : '. $mise);
//            //------------- Generation auto des victoires 1 /defaites 2 --------------//
//            $tirage = rand(1,100);  //-----------------------------------------------------------------activer pour prod ------------//
//            if ($tirage <= $txReussite){
//                $resultat = 1;
//            }else{
//                $resultat = 2;
//            }
//            if ($resultat == 1){
//                $win++;
//            }else{
//                $loose++;
//            }
////            $historique[$i] = $resultat;
//            dump('resueltat : '.$resultat);
//
//            //---------- calcul resultat ------------//
//            // Perdant //
//            if ($resultat == 2){
//                dump('perdant');
//                $serie = 0;
//                $perte = $perte + $mise + $marge;
//                dump('paris perdant, perte : '.$perte);
//                if ($perte > ($marge * $seuilMontantChangementNiveau)){
//                    dump('paris perdant, niveau en cours : '.$niveauEnCours);
//                    if ($perteTotalNiveau == 0){
//                        $perteTotalNiveau = [];
//                        for ($j=0; $j<$nbPalierChangementNiveau; $j++){
//                            $perteTotalNiveau[$j] = $perte / $nbPalierChangementNiveau;
////                            array_push($perteTotalNiveau,  $perte/$nbPalierChangementNiveau);
//                            $initialMise = 1;
//                        }
//                        dump('Set 1erNiveau, perteTotalNiveau : ');
//                        dump($perteTotalNiveau);
//                        $perteTotal = $perte = $perteTotalNiveau[0];
//                        $niveauEnCours = 1;
//                    }else{
//                        $count = count($perteTotalNiveau);
//                        $stopFor = $count + $nbPalierChangementNiveau;
//                        for ($j=$count; $j<$stopFor; $j++){
//                            $perteTotalNiveau[$j] = $perte / $nbPalierChangementNiveau;
//                            $initialMise = 1;
//                        }
//                        dump('Set NiveauComplementaire, perteTotalNiveau : ');
//                        dump($perteTotalNiveau);
//                        $perteTotal = $perte = $perteTotalNiveau[$index];
//                        dump('Set 1erNiveau, perteTotalNiveau : '.$perte);
//                    }
//                }else{
//                    $initialMise = 0;
//                    if ($perte > $perteTotal){
//                        $perteTotal = $perte;
//                    }
//                }
//                dump('perte, miseInitiale : '. $initialMise);
//            }elseif ($resultat == 1){ // Gagnant //
//                dump('gagnant');
//                $solde = $solde + ($mise * $cote);
//                if ($initialMise == 1){
//                    dump('test IF $initialMise == 1');
//                    $perteTotal = $perte = 0;
//                    $serie ++;
//                    $initialMise = 0;
//                    $count = count($perteTotalNiveau);
//                    if ($count == $niveauEnCours && $niveauEnCours != 0){
//                        $niveauEnCours = 0;
//                        $perteTotalNiveau = 0;
//                        $niveauMontant = 0;
//                    }
//                }elseif (($serie +1) == $palier){
//                    dump('test IF ($serie +1) == $palier');
//                    $serie = 0;
//                    $initialMise = 1;
//                    $count = count($perteTotalNiveau);
//                    $perteTotal = $perte = 0;
//                    if($palier == 1){
//                        $niveauEnCours = 0;
//                        $perteTotalNiveau = 0;
//                        $niveauMontant = 0;
//                        $perte = $perteTotal = 0;
//                    }
//                    if ($count == $niveauEnCours && $niveauEnCours != 0){
//                        $niveauEnCours = 0;
//                        $perteTotalNiveau = 0;
//                        $niveauMontant = 0;
//                    }elseif ($niveauEnCours > 0){
//                        $niveauEnCours++;
//                        $perte = $perteTotal = $perteTotalNiveau[$niveauEnCours-1];
//                    }
//                }elseif ($serie < $palier) {
//                    dump('test IF $serie < $palier');
//                    $serie++;
//                    $perte = $perte - ($mise * ($cote -1)) ;
//                }
//                dump('gagnant, miseInitiale : '.$initialMise);
//            }
//            if($perteHistorique < $perte){
//                dump('testGlobal');
//                $perteHistorique = $perte;
//            }
//            $historiqueCount1 = count($perteTotalNiveau);
//            $historiqueCount2 = count($historiquePerteTotalNiveau);
//            if ($historiqueCount1 > $historiqueCount2){
//                $historiquePerteTotalNiveau = $perteTotalNiveau;
//            }
//            dump('solde : '.$solde);
//            if ($solde < $soldeMinHisto){
//                $soldeMinHisto = $solde;
//            }
//        }
//
//
////        dump($historique);
//        dump('perteMax : '.$perteHistorique);
//        dump('maxPerteTotalNiveau');
//        dump($historiquePerteTotalNiveau);
//        dump('soldeTotal : '.$solde);
//        dump('soldeMinimum : '.$soldeMinHisto);
//        dump('victoire :'.$win.', defaite : '.$loose);
//        die;
//    }

    /**
     * @Route("/calculette", name="calculette")
     */
    public function calculetteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('FdjBundle\Form\CalculeteType');
        $form->handleRequest($request);

        $donnees =  $em->getRepository('FdjBundle:Calculette')->findAll();

        if ($donnees === []){

            $calculette = new Calculette();
            $calculette->setPerte(0);
            $calculette->setSerieGain(0);
            $calculette->setPertePrecedente(0);
            $calculette->setPalier(0);
            $em->persist($calculette);
            $em->flush();
            $donnee = $calculette;
        }else{
            $donnee = $donnees[0];
        }
//        dump($donnee);

        if ($form->isSubmitted() && $form->isValid()) {
            $marge = 0.1; //---------------------------------------valeur a parametrer-----------------------------//
//            dump($form->getData(''));
            if ($form->getData()['cote'] != null && $form->getData()['poucentVictoire'] != null ){
                $nbPalier= ceil(($form->getData()['poucentVictoire']/(100-$form->getData()['poucentVictoire'])));
                if($donnee->getSerieGain() == 0){
                    $gainAGenerer = round($donnee->getPerte()/$nbPalier,2, PHP_ROUND_HALF_UP);
                    $mise = round(($gainAGenerer+0.1)/($form->getData()['cote']-1),3);
//                    dump($nbPalier);
//                    dump($gainAGenerer);
                }elseif ($donnee->getSerieGain() <=3){
                    $gainAGenerer = round($donnee->getPertePrecedente()/$donnee->getPalier(),2);
//                    dump($gainAGenerer);
                    $mise = round(($gainAGenerer+$marge)/($form->getData()['cote']-1),3,PHP_ROUND_HALF_UP);
                }else{
                    $mise = round(($marge)/($form->getData()['cote']-1),3,PHP_ROUND_HALF_UP);
                }
//                dump($mise);
                if ($form->getData()['miseEffectue'] != null && $form->getData()['victoire1OuPerte2'] != null ){
                    if ($form->getData()['victoire1OuPerte2'] == 1){
                        if ($donnee->getSerieGain() == 0){
                            $donnee->setPalier($nbPalier);
                        }
                        $donnee->setSerieGain($donnee->getSerieGain()+1);
                        $donnee->setPerte($donnee->getPerte()-($form->getData()['miseEffectue']*$form->getData()['cote']- $form->getData()['miseEffectue']));
                        if ($donnee->getSerieGain() > $donnee->getPalier(0)){
                            $donnee->setSerieGain(0);
                            $donnee->setPertePrecedente(0);
                            $donnee->setPerte(0);
                            $donnee->setPalier(0);
                        }
                        $em->persist($donnee);
                        $em->flush();
                    }elseif ($form->getData()['victoire1OuPerte2'] == 2){
                        $donnee->setSerieGain(1);
                        $donnee->setPertePrecedente($donnee->getPerte()+ $form->getData()['miseEffectue']+ $marge);
                        $donnee->setPerte($donnee->getPerte()+ $form->getData()['miseEffectue']+ $marge);
                        $donnee->setSerieGain(0);
                        $donnee->setPalier(0);
                        $em->persist($donnee);
                        $em->flush();
                    }
                }
                dump($donnee);
            }

            return $this->render('FdjBundle:Default:calculette.html.twig', array(
                'form' => $form->createView(),
                'donnee' => $donnee,
                'mise' => $mise,
            ));
        }

        $mise = 0;

        return $this->render('FdjBundle:Default:calculette.html.twig', array(
            'form' => $form->createView(),
            'donnee' => $donnee,
            'mise' => $mise,
        ));
    }



    /**
     * @Route("/temp", name="temp")
     * @Method({"GET", "POST"})
     */
    public function tempAction()
    {
        $em = $this->getDoctrine()->getManager();
        $matchs = $em->getRepository('FdjBundle:TennisScore')->findAll();
        foreach ($matchs as $match){
            if ($match->getJoueursTennis() == 1){
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
                if ($match->getEquipe1() > $match->getEquipe2() ){
                    $joueur1->setVictoire(1);
                }elseif ($match->getEquipe1() < $match->getEquipe2()){
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
                if ($match->getEquipe1() > $match->getEquipe2() ){
                    $joueur2->setVictoire(0);
                }elseif ($match->getEquipe1() < $match->getEquipe2()){
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
die;

    }


}
