<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\TennisScore;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tennisscore controller.
 *
 * @Route("tennisscore")
 */
class TennisScoreController extends Controller
{
    /**
     * Lists all tennisScore entities.
     *
     * @Route("/", name="tennisscore_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tennisScores = $em->getRepository('FdjBundle:TennisScore')->findAll();

        return $this->render('tennisscore/index.html.twig', array(
            'tennisScores' => $tennisScores,
        ));
    }

    /**
     * Creates a new tennisScore entity.
     *
     * @Route("/new", name="tennisscore_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tennisScore = new Tennisscore();
        $form = $this->createForm('FdjBundle\Form\TennisScoreType', $tennisScore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tennisScore);
            $em->flush($tennisScore);

            return $this->redirectToRoute('tennisscore_show', array('id' => $tennisScore->getId()));
        }

        return $this->render('tennisscore/new.html.twig', array(
            'tennisScore' => $tennisScore,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tennisScore entity.
     *
     * @Route("/{id}", name="tennisscore_show")
     * @Method("GET")
     */
    public function showAction(TennisScore $tennisScore)
    {
        $deleteForm = $this->createDeleteForm($tennisScore);

        return $this->render('tennisscore/show.html.twig', array(
            'tennisScore' => $tennisScore,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tennisScore entity.
     *
     * @Route("/{id}/edit", name="tennisscore_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TennisScore $tennisScore)
    {
        $deleteForm = $this->createDeleteForm($tennisScore);
        $editForm = $this->createForm('FdjBundle\Form\TennisScoreType', $tennisScore);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tennisscore_edit', array('id' => $tennisScore->getId()));
        }

        return $this->render('tennisscore/edit.html.twig', array(
            'tennisScore' => $tennisScore,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tennisScore entity.
     *
     * @Route("/{id}", name="tennisscore_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TennisScore $tennisScore)
    {
        $form = $this->createDeleteForm($tennisScore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tennisScore);
            $em->flush($tennisScore);
        }

        return $this->redirectToRoute('tennisscore_index');
    }

    /**
     * Creates a form to delete a tennisScore entity.
     *
     * @param TennisScore $tennisScore The tennisScore entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TennisScore $tennisScore)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tennisscore_delete', array('id' => $tennisScore->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
