<?php

namespace GarderieBundle\Controller;

use GarderieBundle\Entity\Activitie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActiviteController extends Controller
{
    public function AjouterActiviteAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $activite = new Activitie();
        $form = $this->createForm('GarderieBundle\Form\ActivitieType', $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($activite);
            $em->flush();
            return $this->redirectToRoute('Activite_affiche');
        }
        return $this->render('GarderieBundle:Activite:AjoutActivite.html.twig', array(
            'form' => $form->createView(),

        ));
    }


    public function AfficheActiviteAction()
    {


        $m = $this->getDoctrine()->getManager();
        $activite= $m->getRepository("GarderieBundle:Activitie")->findAll();


        return $this->render('GarderieBundle:Activite:AfficherActivite.html.twig', array(
            'act' => $activite
        ));
    }

    public function deleteClasseAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $activite = $em->getRepository('GarderieBundle:Activitie')->find($id);
        $em->remove($activite);
        $em->flush();


        return $this->redirectToRoute('Activite_affiche');
    }


    public function ModifierActiviteAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $classe = $em->getRepository('GarderieBundle:Activitie')->find($id);
        $editForm = $this->createForm('GarderieBundle\Form\ActivitieType', $classe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('Activite_affiche');
        }

        return $this->render('GarderieBundle:Activite:ModifierActivite.html.twig', array(
            'form' => $editForm->createView(),
        ));
    }


}
