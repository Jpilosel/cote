<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\SportCote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sportcote controller.
 *
 * @Route("sportcote")
 */
class SportCoteController extends Controller
{
    /**
     * Lists all sportCote entities.
     *
     * @Route("/", name="sportcote_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sportCotes = $em->getRepository('FdjBundle:SportCote')->findAll();

        return $this->render('sportcote/index.html.twig', array(
            'sportCotes' => $sportCotes,
        ));
    }

    /**
     * Creates a new sportCote entity.
     *
     * @Route("/new", name="sportcote_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();

        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
        $api = file_get_contents('https://www.parionssport.fr/api/1n2/offre?sport=964500');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
        $jsonapi = json_decode($api, true);
        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
//        var_dump($jsonapi[0]);
//        var_dump($jsonapi[0]['formules']);


        foreach ($jsonapi as $jsonapi2) {
            $formulesBdd = $em->getRepository('FdjBundle:SportCote')->findByEventId($jsonapi2['eventId']);
            $nbFormulesBdd = count($formulesBdd);
            var_dump($nbFormulesBdd);
//            var_dump($jsonapi2);
            $doublon=0;
            for ($a=0; $a<$nbFormulesBdd; $a++){
                if ( $formulesBdd[$a]->getMarketId()== $jsonapi2['marketId'] ) {
                    $doublon = 1;
                }
            }
            if (isset($jsonapi2['marketId']) && $doublon == 0) {
                $sportCote = new Sportcote();
                //            var_dump($sportCote);
                //var_dump($jsonapi2['formules'][6]);
                $sportCote->setEventId($jsonapi2['eventId']);
                $sportCote->setMarketId($jsonapi2['marketId']);
                $sportCote->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                $sportCote->setSportId($jsonapi2['sportId']);
                $sportCote->setIndexP($jsonapi2['index']);
                $sportCote->setMarketTypeGroup($jsonapi2['marketTypeGroup']);
                $sportCote->setMarketType($jsonapi2['marketType']);
                $sportCote->setMarketTypeId($jsonapi2['marketTypeId']);
                $sportCote->setEnd($jsonapi2['end']);
                $sportCote->setLabel($jsonapi2['label']);
                $sportCote->setEventType($jsonapi2['eventType']);
                $sportCote->setCompetition($jsonapi2['competition']);
                $sportCote->setCompetitionId($jsonapi2['competitionId']);
                $nbCoteAnexe = count($jsonapi2['outcomes']);
                if ($nbCoteAnexe == 2) {
                    $sportCote->setUn($jsonapi2['outcomes'][0]['cote']);
                    $sportCote->setDeux($jsonapi2['outcomes'][1]['cote']);
                } elseif ($nbCoteAnexe == 3) {
                    $sportCote->setUn($jsonapi2['outcomes'][0]['cote']);
                    $sportCote->setNul($jsonapi2['outcomes'][1]['cote']);
                    $sportCote->setDeux($jsonapi2['outcomes'][2]['cote']);
                }
                $em->persist($sportCote);
                var_dump($sportCote);
                $em->flush();
                $nbCoteAnexe = $jsonapi2['nbMarkets'];
//                var_dump($nbCoteAnexe);
//                var_dump($jsonapi2);
            }
            for ($p = 0; $p < $jsonapi2['nbMarkets']; $p++) {
                $doublon=0;
                for ($a=0; $a<$nbFormulesBdd; $a++){
                    if ( $formulesBdd[$a]->getMarketId()== $jsonapi2['formules'][$p]['marketId'] ) {
                        $doublon = 1;
                    }
                }
                if (isset($jsonapi2['formules'][$p]['marketId']) && $doublon == 0) {
                    //                var_dump($jsonapi2['formules']);
                    //                    var_dump($p);
                    //                    var_dump($nbCoteAnexe);
                    $sportCote = new Sportcote();
                    $sportCote->setEventId($jsonapi2['formules'][$p]['eventId']);
                    $sportCote->setMarketId($jsonapi2['formules'][$p]['marketId']);
                    $sportCote->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                    $sportCote->setSportId($jsonapi2['formules'][$p]['sportId']);
                    $sportCote->setIndexP($jsonapi2['formules'][$p]['index']);
                    $sportCote->setMarketTypeGroup($jsonapi2['formules'][$p]['marketTypeGroup']);
                    $sportCote->setMarketType($jsonapi2['formules'][$p]['marketType']);
                    $sportCote->setMarketTypeId($jsonapi2['formules'][$p]['marketTypeId']);
                    $sportCote->setEnd($jsonapi2['formules'][$p]['end']);
                    $sportCote->setLabel($jsonapi2['formules'][$p]['label']);
                    $sportCote->setEventType($jsonapi2['eventType']);
                    $sportCote->setCompetition($jsonapi2['formules'][$p]['competition']);
                    $sportCote->setCompetitionId($jsonapi2['formules'][$p]['competitionId']);
                    $nbCoteAnexe = count($jsonapi2['outcomes']);
                    if ($nbCoteAnexe === 2) {
                        $sportCote->setUn($jsonapi2['formules'][$p]['outcomes'][0]['cote']);
                        $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                    } elseif ($nbCoteAnexe === 3) {
                        $sportCote->setUn($jsonapi2['formules'][$p]['outcomes'][0]['cote']);
                        $sportCote->setNul($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                        if (isset($jsonapi2['formules'][$p]['outcomes'][2]['cote'])) {
                            $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][2]['cote']);
                        } else {
                            $sportCote->setNul(null);
                            $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                        }
                    }
                    var_dump($sportCote);
                    $em->persist($sportCote);

                    $em->flush();
                }
            }

        }






            die;
//            $nbParis = count($jsonapi2['marketRes']);
//
//            for ($j=0; $j<$nbParis; $j++) {
//                $formulesBdd = $em->getRepository('FdjBundle:SportCote')->findByEventId($jsonapi2['eventId']);
//                $nbFormulesBdd = count($formulesBdd);
//                $doublon=0;
//                for ($a=0; $a<$nbFormulesBdd; $a++){
//                    if ( $formulesBdd[$a]->getIndexP()== $jsonapi2['marketRes'][$j]['index'] ) {
//                        $doublon = 1;
//                    }
//                }
////                var_dump($doublon);
//                if (isset($jsonapi2['marketRes'][$j]['resultat']) && $doublon == 0) {
//                    $nbResult = count($jsonapi2['marketRes'][$j]['resultat']);
//                    for ($k = 1; $k <= $nbResult; $k++) {
//                        if ($jsonapi2['marketRes'][$j]['resultat'][$k]['winner'] == 1) {
//                            $formules = new Formules();
//                            $formules->setEventId($jsonapi2['eventId']);
//                            $formules->setLabel($jsonapi2['label']);
//                            $formules->setCompetition($jsonapi2['competition']);
//                            $formules->setSportId($jsonapi2['sportId']);
//                            $formules->setCompetitionId($jsonapi2['competitionID']);
//                            $formules->setIndexP($jsonapi2['marketRes'][$j]['index']);
//                            $formules->setMarketType($jsonapi2['marketRes'][$j]['marketType']);
//                            $formules->setMarketTypeGroup($jsonapi2['marketRes'][$j]['marketTypeGroup']);
//                            $formules->setMarketTypeId($jsonapi2['marketRes'][$j]['marketTypeId']);
//                            $formules->setResult($jsonapi2['marketRes'][$j]['resultat'][$k]['label']);
//                        }
//                        var_dump($formules);
//                        $em->persist($formules);
//                        $em->flush();
//                    }
//                }
//            }
//        }
////            }
////        }
//
//
//
//        return $this->render('sportcote/new.html.twig', array(
//            'sportCote' => $sportCote,
//
//        ));
    }

    /**
     * Finds and displays a sportCote entity.
     *
     * @Route("/{id}", name="sportcote_show")
     * @Method("GET")
     */
    public function showAction(SportCote $sportCote)
    {
        $deleteForm = $this->createDeleteForm($sportCote);

        return $this->render('sportcote/show.html.twig', array(
            'sportCote' => $sportCote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sportCote entity.
     *
     * @Route("/{id}/edit", name="sportcote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SportCote $sportCote)
    {
        $deleteForm = $this->createDeleteForm($sportCote);
        $editForm = $this->createForm('FdjBundle\Form\SportCoteType', $sportCote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sportcote_edit', array('id' => $sportCote->getId()));
        }

        return $this->render('sportcote/edit.html.twig', array(
            'sportCote' => $sportCote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sportCote entity.
     *
     * @Route("/{id}", name="sportcote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SportCote $sportCote)
    {
        $form = $this->createDeleteForm($sportCote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sportCote);
            $em->flush($sportCote);
        }

        return $this->redirectToRoute('sportcote_index');
    }

    /**
     * Creates a form to delete a sportCote entity.
     *
     * @param SportCote $sportCote The sportCote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SportCote $sportCote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sportcote_delete', array('id' => $sportCote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
