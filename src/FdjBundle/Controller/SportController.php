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
        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
        for ($i=0; $i<$nbMatch; $i++){
            $sportsBdd = $em->getRepository('FdjBundle:Sport')->findByEventId($jsonapi[$i]['eventId']);
            if ($sportsBdd == null || $jsonapi[$i]['eventId'] != ($sportsBdd[0]->getEventId())){
                $sport = new Sport();
                $sport->setEventId($jsonapi[$i]['eventId']);
                $sport->setMarketId($jsonapi[$i]['marketId']);
                $sport->setHasCombiBonus($jsonapi[$i]['hasCombiBonus']);
                $sport->setSportId($jsonapi[$i]['sportId']);
                $sport->setIndexP($jsonapi[$i]['index']);
                $sport->setMarketType($jsonapi[$i]['marketType']);
                $sport->setMarketTypeGroup($jsonapi[$i]['marketTypeGroup']);
                $sport->setMarketTypeId($jsonapi[$i]['marketTypeId']);
                $sport->setEnd($jsonapi[$i]['end']);
                $sport->setLabel($jsonapi[$i]['label']);
                $sport->setEventType($jsonapi[$i]['eventType']);
                $sport->setCompetition($jsonapi[$i]['competition']);
                $sport->setCompetitionId($jsonapi[$i]['competitionId']);
                $sport->setNbMarkets($jsonapi[$i]['nbMarkets']);
                $em->persist($sport);
                var_dump($sport);
                $em->flush();
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
