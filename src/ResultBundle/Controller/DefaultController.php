<?php

namespace ResultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="cote")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('ResultBundle\Form\FiltreIndexType');

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $txReussite = $nbParis = 0;
        $coteGraph = $nbParisGraph = "";
        $cote[] = $resultats = $nbCote = $nbCote2b = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $resultats = $em->getRepository('ResultBundle:Resultat')->findByResult($data);
            foreach ($resultats as $resultat) {
                $allCote[] = $resultat->getCote1();
                $allCote[] = $resultat->getCote2();
                if ($data['nbResult'] == 3) {
                    $allCote[] = $resultat->getCoteNull();
                }
                $allGagnante[] = $resultat->getCotegagnante();
                $nbParis++;
            }

            $nbCote = array_count_values($allCote);
            $coteGagnante = array_count_values($allGagnante);
            ksort($nbCote);
            ksort($coteGagnante);
            foreach ($nbCote as $key => $value) {
//                var_dump($key);
//                var_dump($value);
                if (isset($coteGagnante[$key])) {
                    $nbCote2b[$key]['taux'] = round((($coteGagnante[$key] / $value) * 100), 2);
                    $nbCote2b[$key]['cote'] = $key;
                    $nbCote2b[$key]['nbParis'] = $value;
//                    $coteGraph .= $key.", ";
//                    $nbParisGraph .= " ,".$value;
                } else {
                    $nbCote2b[$key]['taux'] = 0;
                    $nbCote2b[$key]['cote'] = $key;
                    $nbCote2b[$key]['nbParis'] = 0;
//                    $coteGraph .= $key.", ";
//                    $nbParisGraph .= " ,".'0';
                }

            }
            ksort($nbCote2b);
        }
//        var_dump($coteGraph);
        return $this->render('resultat/cote.html.twig', array(
            'form' => $form->createView(),
            'resultats' => $resultats,
            'txReussite' => $txReussite,
            'nbParis' => $nbParis,
            'nbCote2' => $nbCote,
            'nbCote2b' => $nbCote2b,
//            'coteGraph'=>$coteGraph,
//            'nbParisGraph'=>$nbParisGraph,
        ));
    }
//        return $this->render('ResultBundle:Default:index.html.twig');



}