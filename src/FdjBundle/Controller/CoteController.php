<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\Cote;
use FdjBundle\Entity\MatchFini;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cote controller.
 *
 * @Route("cote")
 */
class CoteController extends Controller
{
    /**
     * Lists all cote entities.
     *
     * @Route("/", name="cote_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cotes = $em->getRepository('FdjBundle:Cote')->findAll();

        return $this->render('cote/index.html.twig', array(
            'cotes' => $cotes,
        ));
    }

    /**
     * Creates a new cote entity.
     *
     * @Route("/new", name="cote_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//        $matchfinis = $em->getRepository('FdjBundle:MatchFini')->findByMatchFini(null);
        $matchfinis = $em->getRepository('FdjBundle:MatchFini')->findAll();
        var_dump(count($matchfinis));
        foreach ($matchfinis as $matchfini) {
            $coteGagnante = $cotePerdante1 = $cotePerdante2 = null;
//            var_dump($matchfini);
//            $sports = $matchfini->getSportId();
//            $cotesSports = $em->getRepository('FdjBundle:Cote')->findBySportId($sports);
            if ($matchfini->getResultat() == 1 ){
                $coteGagnante = $matchfini->getUn();
                $cotePerdante1 = $matchfini->getNul();
                $cotePerdante2 = $matchfini->getDeux();
            }elseif ($matchfini->getResultat() == 'N' ){
                $cotePerdante1 = $matchfini->getUn();
                $coteGagnante = $matchfini->getNul();
                $cotePerdante2 = $matchfini->getDeux();
            }elseif ($matchfini->getResultat() == 2){
                $cotePerdante1 = $matchfini->getUn();
                $cotePerdante2= $matchfini->getNul();
                $coteGagnante = $matchfini->getDeux();
            }
            var_dump($coteGagnante);
            if ($coteGagnante){
                $cotes = $em->getRepository('FdjBundle:Cote')->findByCote($coteGagnante);
                if (!$cotes){
                    $cote = new Cote();
                    $cote->setSportId($matchfini->getSportId());
                    $cote->setCompetition($matchfini->getCompetition());
                    $cote->setCompetitionId($matchfini->getCompetitionId());
                    $cote->setMarketType($matchfini->getMarketType());
                    $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $cote->setResultat($matchfini->getResultat());
                    $cote->setCote($coteGagnante);
                    $cote->setStatut('g');
                    $cote->setRecurrence(1);
                    var_dump($cote);
                    $em->persist($cote);
                    $em->flush();
                }else {
                    foreach ($cotes as $cote) {
                        if ($cote->getSportId() == $matchfini->getSportId() && $cote->getStatut() == 'g' && $cote->getCompetitionId() == $matchfini->getCompetitionId() && $cote->getMarketTypeGroup() == $matchfini->getMarketTypeGroup()) {
                            $recurrence = $cote->getRecurrence() + 1;
                            $cote->setRecurrence($recurrence);
                            $recurrence = null;
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        } else {
                            $cote = new Cote();
                            $cote->setSportId($matchfini->getSportId());
                            $cote->setCompetition($matchfini->getCompetition());
                            $cote->setCompetitionId($matchfini->getCompetitionId());
                            $cote->setMarketType($matchfini->getMarketType());
                            $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                            $cote->setResultat($matchfini->getResultat());
                            $cote->setCote($coteGagnante);
                            $cote->setStatut('g');
                            $cote->setRecurrence(1);
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        }
                    }
                }

            }
            if ($cotePerdante1) {
                $cotes = $em->getRepository('FdjBundle:Cote')->findByCote($cotePerdante1);
                if (!$cotes){
                    $cote = new Cote();
                    $cote->setSportId($matchfini->getSportId());
                    $cote->setCompetition($matchfini->getCompetition());
                    $cote->setCompetitionId($matchfini->getCompetitionId());
                    $cote->setMarketType($matchfini->getMarketType());
                    $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $cote->setResultat($matchfini->getResultat());
                    $cote->setCote($cotePerdante1);
                    $cote->setStatut('p');
                    $cote->setRecurrence(1);
                    var_dump($cote);
                    $em->persist($cote);
                    $em->flush();
                }else {
                    foreach ($cotes as $cote) {
                        if ($cote->getSportId() == $matchfini->getSportId() && $cote->getStatut() == 'p' && $cote->getCompetitionId() == $matchfini->getCompetitionId() && $cote->getMarketTypeGroup() == $matchfini->getMarketTypeGroup()) {
                            $recurrence = $cote->getRecurrence() + 1;
                            $cote->setRecurrence($recurrence);
                            $recurrence = null;
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        } else {
                            $cote = new Cote();
                            $cote->setSportId($matchfini->getSportId());
                            $cote->setCompetition($matchfini->getCompetition());
                            $cote->setCompetitionId($matchfini->getCompetitionId());
                            $cote->setMarketType($matchfini->getMarketType());
                            $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                            $cote->setResultat($matchfini->getResultat());
                            $cote->setCote($cotePerdante1);
                            $cote->setStatut('p');
                            $cote->setRecurrence(1);
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        }
                    }
                }
            }
            if ($cotePerdante2) {
                $cotes = $em->getRepository('FdjBundle:Cote')->findByCote($cotePerdante2);
                if (!$cotes){
                    $cote = new Cote();
                    $cote->setSportId($matchfini->getSportId());
                    $cote->setCompetition($matchfini->getCompetition());
                    $cote->setCompetitionId($matchfini->getCompetitionId());
                    $cote->setMarketType($matchfini->getMarketType());
                    $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                    $cote->setResultat($matchfini->getResultat());
                    $cote->setCote($cotePerdante2);
                    $cote->setStatut('p');
                    $cote->setRecurrence(1);
                    var_dump($cote);
                    $em->persist($cote);
                    $em->flush();
                }else {
                    foreach ($cotes as $cote) {
                        if ($cote->getSportId() == $matchfini->getSportId() && $cote->getStatut() == 'p' && $cote->getCompetitionId() == $matchfini->getCompetitionId() && $cote->getMarketTypeGroup() == $matchfini->getMarketTypeGroup()) {
                            $recurrence = $cote->getRecurrence() + 1;
                            $cote->setRecurrence($recurrence);
                            $recurrence = null;
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        } else {
                            $cote = new Cote();
                            $cote->setSportId($matchfini->getSportId());
                            $cote->setCompetition($matchfini->getCompetition());
                            $cote->setCompetitionId($matchfini->getCompetitionId());
                            $cote->setMarketType($matchfini->getMarketType());
                            $cote->setMarketTypeGroup($matchfini->getMarketTypeGroup());
                            $cote->setResultat($matchfini->getResultat());
                            $cote->setCote($cotePerdante2);
                            $cote->setStatut('p');
                            $cote->setRecurrence(1);
                            var_dump($cote);
                            $em->persist($cote);
                            $em->flush();
                        }
                    }
                }
            }
        }

        return $this->render('cote/new.html.twig');
    }

    /**
     * Finds and displays a cote entity.
     *
     * @Route("/{id}", name="cote_show")
     * @Method("GET")
     */
    public function showAction(cote $cote)
    {
        $deleteForm = $this->createDeleteForm($cote);

        return $this->render('cote/show.html.twig', array(
            'cote' => $cote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cote entity.
     *
     * @Route("/{id}/edit", name="cote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, cote $cote)
    {
        $deleteForm = $this->createDeleteForm($cote);
        $editForm = $this->createForm('FdjBundle\Form\coteType', $cote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cote_edit', array('id' => $cote->getId()));
        }

        return $this->render('cote/edit.html.twig', array(
            'cote' => $cote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cote entity.
     *
     * @Route("/{id}", name="cote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, cote $cote)
    {
        $form = $this->createDeleteForm($cote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cote);
            $em->flush($cote);
        }

        return $this->redirectToRoute('cote_index');
    }

    /**
     * Creates a form to delete a cote entity.
     *
     * @param cote $cote The cote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(cote $cote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cote_delete', array('id' => $cote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
