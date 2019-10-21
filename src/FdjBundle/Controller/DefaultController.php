<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\ApiResultatTennis;
use FdjBundle\Entity\ClassementJoueurs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FdjBundle\Entity\CoteList;
use Symfony\Component\Validator\Constraints\DateTime;
use FdjBundle\Entity\TennisScore;

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
        $tennisScores = $em->getRepository('FdjBundle:TennisScore')->findById(1);
        dump($tennisScores);
        if ($tennisScores != null){
            foreach ($tennisScores as $tennisScore){
                dump($tennisScore);
                if (substr_count($tennisScore->getLabel(), '/' ) == 0){
                    $noms = explode('-', $tennisScore->getLabel());
                    dump($noms);
                    $joueur1 = $noms[0];
                    $joueur2 = $noms[1];
                    $joueur1Nom = explode('.', $joueur1)[1];
                    dump($joueur1Nom);
                    $apiClassementJoueurs = $em->getRepository('FdjBundle:ClassementJoueurs')->findByNom($joueur1Nom);
                    dump($apiClassementJoueurs);
                    if ($apiClassementJoueurs == null){

                    }
                    elseif (count($apiClassementJoueurs) == 1){
                        $apiJoueur = $apiClassementJoueurs[0];
                    }else{
                        $apiJoueur = $apiClassementJoueurs[0];

                        foreach ($apiClassementJoueurs as $apiClassementJoueur) {
                            if ($apiClassementJoueur->getId() > $apiJoueur->getId()){
                                $apiJoueur = $apiClassementJoueur;
                            }
                        }
                    }
                    dump($apiJoueur);
                }

            }
        }


//        dump($tennisScores);



die;
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
