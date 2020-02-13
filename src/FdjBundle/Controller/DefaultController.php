<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\ApiResultatTennis;
use FdjBundle\Entity\ClassementJoueurs;
use FdjBundle\Entity\JoueursTennis;
use FdjBundle\Entity\JoueurTennisScoreCote;
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
     * @Route("/test3", name="test3")
     */
    public function test3Action()
    {
        $em = $this->getDoctrine()->getManager();
        $now = new \datetime();
        $startTxt = $now->format('Y-m-d') . ' 00:00:00';
        dump($startTxt);
        $matchs  = $em->getRepository('FdjBundle:Sport')->findByMatchAVenir($startTxt, '600');
        dump($matchs);
//        die;

        return $this->render('FdjBundle:Default:listeMatchTennis.html.twig', array(
            'matchs' => $matchs,
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
//        dump($match);

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
