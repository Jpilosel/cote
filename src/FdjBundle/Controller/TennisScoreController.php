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
        $marketTypeId17 = $marketTypeId = $win = $loose = $total = $perdant = $gagnant =$deuxZero = $deuxUn = $zeroDeux = $troisUn = $zeroTrois = $troisDeux = $troisZero = $unDeux = $unTrois = $deuxTrois = $deuxSet = $toisSet = $deuxSetFani = $troisSetFani = 0;


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $cote1 = $data['coteMin'];

            $cote2decimal1 = number_format($cote1, 2, ',', '');
            $data['coteMin']=$cote2decimal1;
            $cote2 = $data['coteMax'];
            $cote2decimal2 = number_format($cote2, 2, ',', '');
            $data['coteMax']=$cote2decimal2;
            $tennisScores = $em->getRepository('FdjBundle:TennisScore')->findByTennisResult($data);
            dump($tennisScores);
            foreach ($tennisScores as $tennisScore) {
                if ($tennisScore->getResultat() == '2 - 0'){
                    $deuxZero++;
                    $deuxSet++;
                    $deuxSetFani++;
                    if($tennisScore->getUn() > $tennisScore->getDeux()){
                        $perdant++;
                    }elseif($tennisScore->getUn() < $tennisScore->getDeux()){
                        $gagnant++;
                    }
                }else if ($tennisScore->getResultat() == '2 - 1'){
                    $deuxUn++;
                    $deuxSet++;
                }else if ($tennisScore->getResultat() == '0 - 2'){
                    $zeroDeux++;
                    $deuxSet++;
                    $deuxSetFani++;
                    if($tennisScore->getUn() < $tennisScore->getDeux()){
                        $perdant++;
                    }elseif($tennisScore->getUn() > $tennisScore->getDeux()){
                        $gagnant++;
                    }
                }else if ($tennisScore->getResultat() == '1 - 2'){
                    $unDeux++;
                    $deuxSet++;
                }else if ($tennisScore->getResultat() == '3 - 0'){
                    $troisZero++;
                    $toisSet++;
                    $troisSetFani++;
                    if($tennisScore->getUn() > $tennisScore->getDeux()){
                        $perdant++;
                    }elseif($tennisScore->getUn() < $tennisScore->getDeux()){
                        $gagnant++;
                    }
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
                    if($tennisScore->getUn() < $tennisScore->getDeux()){
                        $perdant++;
                    }elseif($tennisScore->getUn() > $tennisScore->getDeux()){
                        $gagnant++;
                    }
                }else if ($tennisScore->getResultat() == '1 - 3'){
                    $unTrois++;
                    $toisSet++;
                }else if ($tennisScore->getResultat() == '2 - 3'){
                    $deuxTrois++;
                    $toisSet++;
                }
            }
            $tennisCoteCumuls = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,1);
            foreach ($tennisCoteCumuls as $coteCumul){
                $win = $win + $coteCumul->getWin();
                $loose = $loose + $coteCumul->getloose();
                $total = $total + $coteCumul->getWin() + $coteCumul->getloose();
            }

            $tennisCoteCumul7s = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,7);

            $win7 = $loose7= $total7 = 0;
            foreach ($tennisCoteCumul7s as $coteCumul7){
                $marketTypeId = [];
                $marketTypeId['win'] = $win7 + $coteCumul7->getWin();
                $marketTypeId['loose'] = $loose7 + $coteCumul7->getloose();
                $marketTypeId['total'] = $total7 + $coteCumul7->getWin() + $coteCumul7->getloose();
            }

            $tennisCoteCumul17s = $em->getRepository('FdjBundle:TennisCoteCumul')->findByTennisCumulCote($data,17);

            $win17 = $loose17= $total17 = 0;
            foreach ($tennisCoteCumul17s as $coteCumul17){
                $marketTypeId17 = [];
                $marketTypeId17['win'] = $win17 + $coteCumul17->getWin();
                $marketTypeId17['loose'] = $loose17 + $coteCumul17->getloose();
                $marketTypeId17['total'] = $total17 + $coteCumul17->getWin() + $coteCumul17->getloose();
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
                'gagnant'=>$gagnant,
                'perdant'=>$perdant,
                'win'=> $win,
                'loose'=>$loose,
                'total'=>$total,
                'marketTypeId'=>$marketTypeId,
                'marketTypeId17'=>$marketTypeId17,
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
            'troisSet'=>$toisSet,
            'win'=> $win,
            'loose'=>$loose,
            'total'=>$total,
            'marketTypeId'=>$marketTypeId,
                'marketTypeId17'=>$marketTypeId17,
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
