<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

class EvenementController extends Controller
{
    public function AjoutEvenementAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenment = new Evenement();
        $evenment->setNbrparticipant(0);
        $form = $this->createForm('EvenementBundle\Form\EvenementType', $evenment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $evenment->setIamge("3.jpg");
            $evenment->getUploadFile();
            $em->persist($evenment);
            $em->flush();
            return $this->redirectToRoute('evenement_Affiche');
        }
        return $this->render('@Evenement/Evenement/AjouterEvenement.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function AfficheEvenementAction()
    {
        $m = $this->getDoctrine()->getManager();
        $Evenement = $m->getRepository("EvenementBundle:Evenement")->findAll();
        return $this->render('@Evenement/Evenement/AfficheEvenement.html.twig', array(
            'event' => $Evenement,
        ));
    }

    public function deleteEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Evenements = $em->getRepository("EvenementBundle:Evenement")->find($id);
        $reservation=$em->getRepository("EvenementBundle:Reservation")->findBy(array('idevenement'=>$id));
        $em->remove($Evenements);
        $em->flush();

        return $this->redirectToRoute('evenement_Affiche');

    }

    public function editEvenementAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository('EvenementBundle:Evenement')->find($id);

        $editForm = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('evenement_Affiche');
        }

        return $this->render('@Evenement/Evenement/editEvenement.html.twig', array(
            'event' => $evenement,
            'form' => $editForm->createView(),
        ));
    }


    public function AfficheEvenementFrontAction()
    {
        $m = $this->getDoctrine()->getManager();
        $Evenement = $m->getRepository("EvenementBundle:Evenement")->findAll();
        return $this->render('@Evenement/Evenement/FrontEvent.html.twig', array(
            'event' => $Evenement,
        ));
    }

}
