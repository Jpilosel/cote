<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\ApiResultatTennis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FdjBundle\Entity\CoteList;
use Symfony\Component\Validator\Constraints\DateTime;

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
            var_dump($listes);


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
        $now = new \DateTime();
        $now->modify('-1 day');
        $lien = 'https://api.sportradar.com/tennis-t2/fr/schedules/'.$now->format('Y-m-d').'/results.json?api_key=dysqrwevnpemdfvanjr4rwtc';

        $api = file_get_contents('https://api.sportradar.com/tennis-t2/fr/schedules/2019-10-15/results.json?api_key=dysqrwevnpemdfvanjr4rwtc');
        $matchs = json_decode($api, true);

        foreach ($matchs['results'] as $match){
            $doublon  = $em->getRepository('FdjBundle:ApiResultatTennis')->findOneByIdMatch($match['sport_event']['id']);
            if ($doublon == null){
                $name = $match['sport_event']['tournament']['name'];
                $name = explode(" ", $name);
                $minName = $name[0];
                if ($minName == "ATP" or $minName == "WTA"){
                    if ($match["sport_event_status"]["match_status"] == "ended" && $match['sport_event']['tournament']["type"]  == "singles"){
                        dump($match);
                        $apiResultatTennis = new ApiResultatTennis();
                        var_dump($match['sport_event']['tournament']['name']);
                        $apiResultatTennis->setIdMatch($match['sport_event']['id']);
                        $dateTxt = substr($match['sport_event']['scheduled'],0,-15);
                        $date = new \DateTime($dateTxt);
                        $apiResultatTennis->setDate($date);
                        $apiResultatTennis->setNomTournois($match['sport_event']['tournament']['name']);
                        $apiResultatTennis->setIdTournois($match['sport_event']['tournament']['id']);
                        $apiResultatTennis->setType($match['sport_event']['tournament']['type']);
                        $apiResultatTennis->setGenre($match['sport_event']['tournament']['gender']);
                        $apiResultatTennis->setManche($match['sport_event']['tournament_round']['name']);
                        $apiResultatTennis->setJoueur1Id($match['sport_event']['competitors'][0]["id"]);
                        $apiResultatTennis->setJoueur1Nom($match['sport_event']['competitors'][0]["name"]);
                        $apiResultatTennis->setJoueur1Nationalite($match['sport_event']['competitors'][0]["nationality"]);
                        $apiResultatTennis->setJoueur1BracketNumber($match['sport_event']['competitors'][0]["bracket_number"]);
                        $apiResultatTennis->setJoueur1Qualifier($match['sport_event']['competitors'][0]["qualifier"]);
                        $apiResultatTennis->setJoueur2Id($match['sport_event']['competitors'][1]["id"]);
                        $apiResultatTennis->setJoueur2Nom($match['sport_event']['competitors'][1]["name"]);
                        $apiResultatTennis->setJoueur2Nationalite($match['sport_event']['competitors'][1]["nationality"]);
                        $apiResultatTennis->setJoueur2BracketNumber($match['sport_event']['competitors'][1]["bracket_number"]);
                        $apiResultatTennis->setJoueur2Qualifier($match['sport_event']['competitors'][1]["qualifier"]);
                        $apiResultatTennis->setIdGagnant($match['sport_event_status']['winner_id']);
                        $apiResultatTennis->setResultatMatchJ1($match['sport_event_status']['home_score']);
                        $apiResultatTennis->setResultatMatchJ2($match['sport_event_status']['away_score']);
                        foreach ($match['sport_event_status']['period_scores'] as $score){
                            if ($score["number"] == 1){
                                $apiResultatTennis->setScoreS1J1($score["home_score"]);
                                $apiResultatTennis->setScoreS1J2($score["away_score"]);
                            }elseif ($score["number"] == 2){
                                $apiResultatTennis->setScoreS2J1($score["home_score"]);
                                $apiResultatTennis->setScoreS2J2($score["away_score"]);
                            }elseif ($score["number"] == 3){
                                $apiResultatTennis->setScoreS3J1($score["home_score"]);
                                $apiResultatTennis->setScoreS3J2($score["away_score"]);
                            }elseif ($score["number"] == 4){
                                $apiResultatTennis->setScoreS4J1($score["home_score"]);
                                $apiResultatTennis->setScoreS4J2($score["away_score"]);
                            }elseif ($score["number"] == 5){
                                $apiResultatTennis->setScoreS5J1($score["home_score"]);
                                $apiResultatTennis->setScoreS5J2($score["away_score"]);
                            }
                        }
                        $em->persist($apiResultatTennis);
                        $em->flush();


                    }

                }

            }


        }



        return $this->render('FdjBundle:Default:index.html.twig');

    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats');//9 resultat sans cote
//        $api =file_get_contents('https://www.parionssport.fr/parisouverts/football');//9 resultat sans cote
//        $api =file_get_contents('https://www.parionssport.fr/api/competitions/1n2/100');//liste des competition nom + id
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/offre?sport=964500');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats?sport=100');//9 resultats ! sport 600 ne marche plus
//        $api =file_get_contents('https://www.parionssport.fr/api/combi-bonus/resultats');// beaucoup de resultat sur des pronostic pas de resultat precis
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats?sport=600'); //9 résultat sans cote trier par sport
//        $lastMaj =file_get_contents('https://www.parionssport.fr/api/date/last-update'); //dernière MAJ
//        $api =file_get_contents('https://www.unibet.fr/zones/calendar/nextbets.json?limitHours=&from=07/02/2017&willBeLive=false&isOnPlayer=false'); //unibet
//        $api =file_get_contents('https://ls.betradar.com/ls/feeds/?/winamaxfr/fr/Africa:Lagos/gismo/event_get'); //winamax resultat
//        $api =file_get_contents('https://ls.betradar.com/ls/feeds/?/winamaxfr/fr/Africa:Lagos/gismo/bet_get/winamaxfr/0'); //winamax
        $api =file_get_contents('https://ls.betradar.com/ls/feeds/?/winamaxfr/fr/Africa:Lagos/gismo/event_get'); //winamax resultat juste avec ID

        $jsonapi =  json_decode($api, true);
//        $jsonLastMaj =  json_decode($lastMaj, true);
//        var_dump($jsonapi[0]['formules'][0]['outcomes']);
//        var_dump($jsonLastMaj);
//          var_dump($jsonapi['doc'][0]['data'][6]); //winamax nom
//          var_dump($jsonapi['doc'][0]['data'][6]['match']['teams']); //winamax nom
//          var_dump($jsonapi['doc'][0]['data'][6]['match']['periods']); //winamax nom
//          var_dump($jsonapi['doc'][0]['data'][3]['match']['result']);//winamax result
        var_dump($jsonapi['doc'][0]['data'][0]);//result unibet
        var_dump($jsonapi['doc'][0]['data']);//result unibet





        return $this->render('FdjBundle:Default:index.html.twig');
    }
}
