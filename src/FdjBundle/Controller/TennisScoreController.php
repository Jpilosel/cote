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
     * @Route("/result", name="tennisscore_result")
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
     * Lists all tennisScore entities.
     *
     * @Route("/", name="tennisscore_index")
     * @Method({"GET", "POST"})
     */
    public function resultAction(Request $request)
    {
        $form = $this->createForm('FdjBundle\Form\TennisScore2Type');
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $deuxZero = $deuxUn = $zeroDeux = $troisUn = $zeroTrois = $troisDeux = $troisZero = $unDeux = $unTrois = $deuxTrois = $deuxSet = $toisSet = $deuxSetFani = $troisSetFani = 0;


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $nbSetGagnant=$data['nbSetGagnant'];
            $tennisScores = $em->getRepository('FdjBundle:TennisScore')->findByTennisResult($data);
            foreach ($tennisScores as $tennisScore) {
                if ($tennisScore->getResultat() == '2 - 0'){
                    $deuxZero++;
                    $deuxSet++;
                    $deuxSetFani++;
                }else if ($tennisScore->getResultat() == '2 - 1'){
                    $deuxUn++;
                    $deuxSet++;
                }else if ($tennisScore->getResultat() == '0 - 2'){
                    $zeroDeux++;
                    $deuxSet++;
                    $deuxSetFani++;
                }else if ($tennisScore->getResultat() == '1 - 2'){
                    $unDeux++;
                    $deuxSet++;
                }else if ($tennisScore->getResultat() == '3 - 0'){
                    $troisZero++;
                    $toisSet++;
                    $troisSetFani++;
                }else if ($tennisScore->getResultat() == '3 - 1'){
                    $troisUn++;
                    $toisSet++;
                }else if ($tennisScore->getResultat() == '3 - 2'){
                    $troisDeux++;
                    $toisSet++;
                }else if ($tennisScore->getResultat() == '0 - 3'){
                    $zeroTrois++;
                    $toisSet++;
                    $troisSetFani++;
                }else if ($tennisScore->getResultat() == '1 - 3'){
                    $unTrois++;
                    $toisSet++;
                }else if ($tennisScore->getResultat() == '2 - 3'){
                    $deuxTrois++;
                    $toisSet++;
                }
            }

            return $this->render('tennisscore/result.html.twig', array(
                'tennisScores' => $tennisScores,
                'form' => $form->createView(),
                'deuxZero'=>$deuxZero,
                'deuxUn'=>$deuxUn,
                'zeroDeux'=>$zeroDeux,
                'troisUn'=>$troisUn,
                'zeroTrois'=>$zeroTrois,
                'troisDeux'=>$troisDeux,
                'troisZero'=>$troisZero,
                'unDeux'=>$unDeux,
                'unTrois'=>$unTrois,
                'deuxTrois'=>$deuxTrois,
                'deuxSet'=>$deuxSet,
                'troisSet'=>$toisSet,
                'deuxSetFani'=>$deuxSetFani,
                'troisSetFani'=>$troisSetFani,
            ));
        }

        return $this->render('tennisscore/result.html.twig', array(
            'form' => $form->createView(),
            'deuxZero'=>$deuxZero,
            'deuxUn'=>$deuxUn,
            'zeroDeux'=>$zeroDeux,
            'troisUn'=>$troisUn,
            'zeroTrois'=>$zeroTrois,
            'troisDeux'=>$troisDeux,
            'troisZero'=>$troisZero,
            'unDeux'=>$unDeux,
            'unTrois'=>$unTrois,
            'deuxTrois'=>$deuxTrois,
            'deuxSet'=>$deuxSet,
            'troisSet'=>$toisSet
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
