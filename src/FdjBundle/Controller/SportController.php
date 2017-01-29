<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\Formules;
use FdjBundle\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sport controller.
 *
 * @Route("sport")
 */
class SportController extends Controller
{
    /**
     * Lists all sport entities.
     *
     * @Route("/", name="sport_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sports = $em->getRepository('FdjBundle:Sport')->findAll();

        return $this->render('sport/index.html.twig', array(
            'sports' => $sports,
        ));
    }

    /**
     * Creates a new sport entity.
     *
     * @Route("/new", name="sport_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
        $em = $this->getDoctrine()->getManager();
//        $sport = new Sport();
        $api =file_get_contents('https://www.parionssport.fr/api/1n2/offre');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
        $jsonapi =  json_decode($api, true);
        var_dump($jsonapi[0]);
        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
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
                $sportCote = new Sport();
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
                    $sportCote = new Sport();
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
                        if (isset($jsonapi2['formules'][$p]['outcomes'][1]['cote'])) {
                            $sportCote->setNul($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                        }
                        if (isset($jsonapi2['formules'][$p]['outcomes'][2]['cote'])) {
                            $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][2]['cote']);
                        } else {
                            $sportCote->setNul(null);
                            if (isset($jsonapi2['formules'][$p]['outcomes'][1]['cote'])) {
                                $sportCote->setDeux($jsonapi2['formules'][$p]['outcomes'][1]['cote']);
                            }
                        }
                    }
                    var_dump($sportCote);
                    $em->persist($sportCote);

                    $em->flush();
                }
            }

        }
die;
        return $this->render('@Result/Default/sport_new_auto.html.twig', array(
            'sport' => $sport,

        ));
    }

    /**
     * Finds and displays a sport entity.
     *
     * @Route("/{id}", name="sport_show")
     * @Method("GET")
     */
    public function showAction(Sport $sport)
    {
        $deleteForm = $this->createDeleteForm($sport);

        return $this->render('sport/show.html.twig', array(
            'sport' => $sport,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sport entity.
     *
     * @Route("/{id}/edit", name="sport_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sport $sport)
    {
        $deleteForm = $this->createDeleteForm($sport);
        $editForm = $this->createForm('FdjBundle\Form\SportType', $sport);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sport_edit', array('id' => $sport->getId()));
        }

        return $this->render('sport/edit.html.twig', array(
            'sport' => $sport,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sport entity.
     *
     * @Route("/{id}", name="sport_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sport $sport)
    {
        $form = $this->createDeleteForm($sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sport);
            $em->flush($sport);
        }

        return $this->redirectToRoute('sport_index');
    }

    /**
     * Creates a form to delete a sport entity.
     *
     * @param Sport $sport The sport entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sport $sport)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sport_delete', array('id' => $sport->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
