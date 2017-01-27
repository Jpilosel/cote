<?php

namespace FdjBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats');//9 resultat sans cote
//        $api =file_get_contents('https://www.parionssport.fr/parisouverts/football');//9 resultat sans cote
//        $api =file_get_contents('https://www.parionssport.fr/api/competitions/1n2/100');//liste des competition nom + id
        $api =file_get_contents('https://www.parionssport.fr/api/1n2/offre?sport=964500');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats?sport=100');//9 resultats ! sport 600 ne marche plus
//        $api =file_get_contents('https://www.parionssport.fr/api/combi-bonus/resultats');// beaucoup de resultat sur des pronostic pas de resultat precis
//        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats?sport=600'); //9 résultat sans cote trier par sport
        $lastMaj =file_get_contents('https://www.parionssport.fr/api/date/last-update'); //dernière MAJ
        $jsonapi =  json_decode($api, true);
        $jsonLastMaj =  json_decode($lastMaj, true);
//        var_dump($jsonapi[0]['formules'][0]['outcomes']);
//        var_dump($jsonLastMaj);
        var_dump($jsonapi[0]);
//        var_dump($api);
        return $this->render('FdjBundle:Default:index.html.twig');
    }
}
