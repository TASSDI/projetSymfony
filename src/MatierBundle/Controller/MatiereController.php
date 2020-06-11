<?php

namespace MatierBundle\Controller;

use MatierBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MatiereController extends Controller
{

    public function count()
    {
        $count = 0;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MatierBundle:Matiere")->findAll();
        foreach ($commentaire as $e){
            $count = $count + 1;
        }

        return $count;

    }
    public function AjouterMatiereAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $matiere = new Matiere();
        $form = $this->createForm('MatierBundle\Form\MatiereType', $matiere);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($matiere);
            $em->flush();
            return $this->redirectToRoute('matier_afficher');
        }
        return $this->render('MatierBundle:Matiere:AjoutMatiere.html.twig', array(
            'form' => $form->createView(),

        ));
    }
    public function AfficheMatiereAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $count = $this->count();
        $m = $this->getDoctrine()->getManager();
        $matiere= $m->getRepository("MatierBundle:Matiere")->findAll();
        return $this->render('MatierBundle:Matiere:AffichierMatiere.html.twig', array(
            'mat' => $matiere,
            'c'=>$count
        ));
    }


    public function deleteMatiereAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $matiere = $em->getRepository('MatierBundle:Matiere')->find($id);
        $em->remove($matiere);
        $em->flush();


        return $this->redirectToRoute('matier_afficher');
    }

    public function ModifierMatierAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $classe = $em->getRepository('MatierBundle:Matiere')->find($id);
        $editForm = $this->createForm('MatierBundle\Form\MatiereType', $classe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('matier_afficher');
        }

        return $this->render('MatierBundle:Matiere:ModifierMatiere.html.twig', array(
            'form' => $editForm->createView(),
        ));
    }
    

}
