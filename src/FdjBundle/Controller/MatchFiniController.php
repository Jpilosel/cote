<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\MatchFini;
use FdjBundle\Entity\Formules;
use FdjBundle\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Matchfini controller.
 *
 * @Route("matchfini")
 */
class MatchFiniController extends Controller
{
    /**
     * Lists all matchFini entities.
     *
     * @Route("/", name="matchfini_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $matchFinis = $em->getRepository('FdjBundle:MatchFini')->findAll();

        return $this->render('matchfini/index.html.twig', array(
            'matchFinis' => $matchFinis,
        ));
    }

    /**
     * Creates a new matchFini entity.
     *
     * @Route("/new", name="matchfini_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $resultats = $em->getRepository('FdjBundle:Formules')->findAll();

        foreach ($resultats as $resultat) {
            $eventId = $resultat->getEventId();

            $matchs = $em->getRepository('FdjBundle:Sport')->findByEventId($eventId);
//            var_dump($matchs);
            if ($matchs) {


//                var_dump($matchFini);
                foreach ($matchs as $match) {
//                    var_dump($match);
                    $marketId = $match->getMarketId();
                    $matchsFinis = $em->getRepository('FdjBundle:MatchFini')->findByMarketId($marketId);

                    if ($matchsFinis){
//                        var_dump($matchsFinis[0]->getMarketTypeGroup());
//                        var_dump($matchsFinis[0]->getSportId());
                    }else {
//                    var_dump($resultat->getMarketType());
//                    var_dump($match->getMarketType());
//                    var_dump($match->getMarketTypeGroup());
                        if ($match->getMarketTypeGroup() == $resultat->getMarketType()) {
                            $matchFini = new Matchfini();
                            $matchFini->setEventId($match->getEventId());
                            $matchFini->setMarketId($match->getMarketId());
                            $matchFini->setHasCombiBonus($match->getHasCombiBonus());
                            $matchFini->setSportId($match->getSportId());
                            $matchFini->setIndexP($match->getIndexP());
                            $matchFini->setMarketType($match->getMarketType());
                            $matchFini->setMarketTypeGroup($match->getMarketTypeGroup());
                            $matchFini->setMarketTypeId($match->getmarketTypeId());
                            $matchFini->setEnd($match->getEnd());
                            $matchFini->setLabel($match->getLabel());
                            $matchFini->setEventType($match->getEventType());
                            $matchFini->setCompetition($match->getCompetition());
                            $matchFini->setCompetitionId($match->getCompetitionId());
                            $matchFini->setNbMarkets($match->getNbMarkets());
                            $matchFini->setUn($match->getUn());
                            $matchFini->setNul($match->getNul());
                            $matchFini->setDeux($match->getDeux());
                            $matchFini->setResultat($resultat->getResult());
                            var_dump($matchFini);
                            $em->persist($matchFini);
                            $match->setOk(1);
                            $em->persist($match);
                            $resultat->setOk(1);
                            $em->persist($resultat);
                            $em->flush();
                        }
                    }
                }
//
//                var_dump($resultat);
//                var_dump($match);
            }

        }




//            $em->persist($matchFini);
//            $em->flush($matchFini);
        return $this->render('matchfini/index.html.twig');

    }

    /**
     * Finds and displays a matchFini entity.
     *
     * @Route("/{id}", name="matchfini_show")
     * @Method("GET")
     */
    public function showAction(MatchFini $matchFini)
    {
        $deleteForm = $this->createDeleteForm($matchFini);

        return $this->render('matchfini/show.html.twig', array(
            'matchFini' => $matchFini,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing matchFini entity.
     *
     * @Route("/{id}/edit", name="matchfini_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MatchFini $matchFini)
    {
        $deleteForm = $this->createDeleteForm($matchFini);
        $editForm = $this->createForm('FdjBundle\Form\MatchFiniType', $matchFini);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matchfini_edit', array('id' => $matchFini->getId()));
        }

        return $this->render('matchfini/edit.html.twig', array(
            'matchFini' => $matchFini,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a matchFini entity.
     *
     * @Route("/{id}", name="matchfini_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MatchFini $matchFini)
    {
        $form = $this->createDeleteForm($matchFini);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($matchFini);
            $em->flush($matchFini);
        }

        return $this->redirectToRoute('matchfini_index');
    }

    /**
     * Creates a form to delete a matchFini entity.
     *
     * @param MatchFini $matchFini The matchFini entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MatchFini $matchFini)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matchfini_delete', array('id' => $matchFini->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
