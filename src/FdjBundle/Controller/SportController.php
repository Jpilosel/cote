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
//        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
        $em = $this->getDoctrine()->getManager();

        $api = file_get_contents('https://www.parionssport.fr/api/1n2/offre');//match sans resultat debut au lancement de l'api, beaucoup de match avec les cotes + cote alternative
        $jsonapi = json_decode($api, true);

        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
//        var_dump($jsonapi[0]);

        foreach ($jsonapi as $jsonapi2) {
//            var_dump($jsonapi2);
            $formulesBdd = $em->getRepository('FdjBundle:Sport')->findByMarketId($jsonapi2['marketId']);

            if (!$formulesBdd) {
                if (($jsonapi2['marketTypeId']) == 4 || ($jsonapi2['marketTypeId']) == 40 || ($jsonapi2['marketTypeId']) == 23 || ($jsonapi2['marketTypeId']) == 5) {

                } else {
                    $sport = new sport();
                    $sport->setEventId($jsonapi2['eventId']);
                    $sport->setMarketId($jsonapi2['marketId']);
                    $sport->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                    $sport->setSportId($jsonapi2['sportId']);
                    $sport->setIndexP($jsonapi2['index']);
                    $sport->setMarketTypeGroup($jsonapi2['marketTypeGroup']);
                    $sport->setMarketType($jsonapi2['marketType']);
                    $sport->setMarketTypeId($jsonapi2['marketTypeId']);
                    $sport->setEnd($jsonapi2['end']);
                    $sport->setLabel($jsonapi2['label']);
                    $sport->setEventType($jsonapi2['eventType']);
                    $sport->setCompetition($jsonapi2['competition']);
                    $sport->setCompetitionId($jsonapi2['competitionId']);
                    $nbResultCote = count($jsonapi2['outcomes']);
                    if ($nbResultCote == 2) {
                        $sport->setUn($jsonapi2['outcomes'][0]['cote']);
                        $sport->setDeux($jsonapi2['outcomes'][1]['cote']);
                    } elseif ($nbResultCote == 3) {
                        $sport->setUn($jsonapi2['outcomes'][0]['cote']);
                        $sport->setNul($jsonapi2['outcomes'][1]['cote']);
                        $sport->setDeux($jsonapi2['outcomes'][2]['cote']);
                    }
                    $em->persist($sport);
                    var_dump($sport);
                    $em->flush();
                }
            }
//            var_dump($jsonapi2['formules']);
            if ($jsonapi2['formules']) {
                foreach ($jsonapi2['formules'] as $jsonapi3) {
//                    var_dump($jsonapi3['marketId']);
                    $formulesBdd2 = $em->getRepository('FdjBundle:Sport')->findByMarketId($jsonapi3['marketId']);
                    if (!$formulesBdd2) {
                        if (($jsonapi3['marketTypeId']) == 4 || ($jsonapi3['marketTypeId']) == 40 || ($jsonapi3['marketTypeId']) == 23 || ($jsonapi3['marketTypeId']) == 5) {

                        } else {
                            var_dump($formulesBdd2);
                            $sport = new sport();
                            $sport->setEventId($jsonapi3['eventId']);
                            $sport->setMarketId($jsonapi3['marketId']);
                            $sport->setHasCombiBonus($jsonapi2['hasCombiBonus']);
                            $sport->setSportId($jsonapi3['sportId']);
                            $sport->setIndexP($jsonapi3['index']);
                            $sport->setMarketTypeGroup($jsonapi3['marketTypeGroup']);
                            $sport->setMarketType($jsonapi3['marketType']);
                            $sport->setMarketTypeId($jsonapi3['marketTypeId']);
                            $sport->setEnd($jsonapi3['end']);
                            $sport->setLabel($jsonapi3['label']);
                            $sport->setEventType($jsonapi2['eventType']);
                            $sport->setCompetition($jsonapi3['competition']);
                            $sport->setCompetitionId($jsonapi3['competitionId']);
                            $nbResultCote = count($jsonapi3['outcomes']);
                            if ($nbResultCote == 2) {
                                $sport->setUn($jsonapi3['outcomes'][0]['cote']);
                                $sport->setDeux($jsonapi3['outcomes'][1]['cote']);
                            } elseif ($nbResultCote == 3) {
                                $sport->setUn($jsonapi3['outcomes'][0]['cote']);
                                $sport->setNul($jsonapi3['outcomes'][1]['cote']);
                                $sport->setDeux($jsonapi3['outcomes'][2]['cote']);
                            }
                            $em->persist($sport);
                            var_dump($sport);
                            $em->flush();
                        }
                    }
                }
            }

        }

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
