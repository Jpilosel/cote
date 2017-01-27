<?php

namespace FdjBundle\Controller;

use FdjBundle\Entity\Formules;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Formule controller.
 *
 * @Route("formules")
 */
class FormulesController extends Controller
{
    /**
     * Lists all formule entities.
     *
     * @Route("/", name="formules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $formules = $em->getRepository('FdjBundle:Formules')->findAll();

        return $this->render('formules/index.html.twig', array(
            'formules' => $formules,
        ));
    }

    /**
     * Creates a new formule entity.
     *
     * @Route("/new", name="formules_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        var_dump(file_get_contents('https://www.parionssport.fr/api/date/last-update'));
        $api =file_get_contents('https://www.parionssport.fr/api/1n2/resultats');//9 resultat sans cote
        $jsonapi =  json_decode($api, true);
        $nbMatch = count($jsonapi);
        var_dump($nbMatch);
        foreach ($jsonapi as $jsonapi2) {
            $nbParis = count($jsonapi2['marketRes']);
            for ($j=0; $j<$nbParis; $j++) {
                $formulesBdd = $em->getRepository('FdjBundle:Formules')->findByEventId($jsonapi2['eventId']);
                $nbFormulesBdd = count($formulesBdd);
                $doublon=0;
                for ($a=0; $a<$nbFormulesBdd; $a++){
                    if ( $formulesBdd[$a]->getIndexP()== $jsonapi2['marketRes'][$j]['index'] ) {
                        $doublon = 1;
                    }
                }
//                var_dump($doublon);

                    if (isset($jsonapi2['marketRes'][$j]['resultat']) && $doublon == 0) {
                        $nbResult = count($jsonapi2['marketRes'][$j]['resultat']);
                        for ($k = 1; $k <= $nbResult; $k++) {
                            if ($jsonapi2['marketRes'][$j]['resultat'][$k]['winner'] == 1) {
                                $formules = new Formules();
                                $formules->setEventId($jsonapi2['eventId']);
                                $formules->setLabel($jsonapi2['label']);
                                $formules->setCompetition($jsonapi2['competition']);
                                $formules->setSportId($jsonapi2['sportId']);
                                $formules->setCompetitionId($jsonapi2['competitionID']);
                                $formules->setIndexP($jsonapi2['marketRes'][$j]['index']);
                                $formules->setMarketType($jsonapi2['marketRes'][$j]['marketType']);
                                $formules->setMarketTypeGroup($jsonapi2['marketRes'][$j]['marketTypeGroup']);
                                $formules->setMarketTypeId($jsonapi2['marketRes'][$j]['marketTypeId']);
                                $formules->setResult($jsonapi2['marketRes'][$j]['resultat'][$k]['label']);
                            }
                            if (isset($formules)) {
                                var_dump($formules);
                                $em->persist($formules);
                                $em->flush();
                            }
                        }
                    }
                }
        }
//            }
//        }
die;
//


        return $this->render('formules/new.html.twig', array(
            'formules' => $formules,

        ));
    }

    /**
     * Finds and displays a formule entity.
     *
     * @Route("/{id}", name="formules_show")
     * @Method("GET")
     */
    public function showAction(Formules $formule)
    {
        $deleteForm = $this->createDeleteForm($formule);

        return $this->render('formules/show.html.twig', array(
            'formule' => $formule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing formule entity.
     *
     * @Route("/{id}/edit", name="formules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Formules $formule)
    {
        $deleteForm = $this->createDeleteForm($formule);
        $editForm = $this->createForm('FdjBundle\Form\FormulesType', $formule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formules_edit', array('id' => $formule->getId()));
        }

        return $this->render('formules/edit.html.twig', array(
            'formule' => $formule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a formule entity.
     *
     * @Route("/{id}", name="formules_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Formules $formule)
    {
        $form = $this->createDeleteForm($formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formule);
            $em->flush($formule);
        }

        return $this->redirectToRoute('formules_index');
    }

    /**
     * Creates a form to delete a formule entity.
     *
     * @param Formules $formule The formule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Formules $formule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formules_delete', array('id' => $formule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
