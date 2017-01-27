<?php

namespace ResultBundle\Controller;

use ResultBundle\Entity\Resultat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resultat controller.
 *
 * @Route("resultat")
 */
class ResultatController extends Controller
{
    /**
     * Lists all resultat entities.
     *
     * @Route("/", name="resultat_index")
     *
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('ResultBundle\Form\FiltreType');
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $resultats = $em->getRepository('ResultBundle:Resultat')->findAll();
        $txReussite= $coteGagnante = $nbParis = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
//            var_dump($data['nbResult']);
            $cote = $data['cote'];
            $cote= str_replace('.',',',$data['cote']);
            $data['cote']=$cote;
            $resultats = $em->getRepository('ResultBundle:Resultat')->findByMySearch($data);
            $win = 0;
//            var_dump($data);
//            var_dump($resultats);
            foreach ($resultats as $resultat) {

                $listeCote[] = $resultat->getCote1();
                $listeCote[] = $resultat->getCote2();
                if($data['nbResult'] === 3) {
                    $listeCote[] = $resultat->getCoteNull();
                }
                $coteGagnante[] = $resultat->getCotegagnante();
                if ($resultat->getCotegagnante() == $data['cote']) {
                    $win++;
                }
            }
            $nbParis = count($coteGagnante);
            if($nbParis != 0){
                $txReussite = round(($win / $nbParis) * 100, 2);
            }


            var_dump($txReussite);
//var_dump($data['cote']);
//            return $this->redirectToRoute('resultat_show', array('id' => $resultat->getId()));
        }
//var_dump($resultats);

        return $this->render('resultat/index.html.twig', array(
            'form' => $form->createView(),
            'resultats' => $resultats,
            'txReussite' => $txReussite,
            'nbParis' => $nbParis,
        ));
    }

    /**
     * Creates a new resultat entity.
     *
     * @Route("/new", name="resultat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $resultat = new Resultat();
        $form = $this->createForm('ResultBundle\Form\ResultatType', $resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resultat);
            $em->flush($resultat);

            return $this->redirectToRoute('resultat_show', array('id' => $resultat->getId()));
        }

        return $this->render('resultat/new.html.twig', array(
            'resultat' => $resultat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a resultat entity.
     *
     * @Route("/{id}", name="resultat_show")
     * @Method("GET")
     */
    public function showAction(Resultat $resultat)
    {
        $deleteForm = $this->createDeleteForm($resultat);

        return $this->render('resultat/show.html.twig', array(
            'resultat' => $resultat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing resultat entity.
     *
     * @Route("/{id}/edit", name="resultat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Resultat $resultat)
    {
        $deleteForm = $this->createDeleteForm($resultat);
        $editForm = $this->createForm('ResultBundle\Form\ResultatType', $resultat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resultat_edit', array('id' => $resultat->getId()));
        }

        return $this->render('resultat/edit.html.twig', array(
            'resultat' => $resultat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a resultat entity.
     *
     * @Route("/{id}", name="resultat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Resultat $resultat)
    {
        $form = $this->createDeleteForm($resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resultat);
            $em->flush($resultat);
        }

        return $this->redirectToRoute('resultat_index');
    }

    /**
     * Creates a form to delete a resultat entity.
     *
     * @param Resultat $resultat The resultat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Resultat $resultat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resultat_delete', array('id' => $resultat->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }



}
