<?php

namespace MatierBundle\Controller;

use MatierBundle\Entity\Emploi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmploiController extends Controller
{

    public function AjouterEmploiEnseignantAction( \Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $emploi = new Emploi();
        $user= $em->getRepository("UserBundle:User")->find(array('id'=>$id));

        $emploi->setUser($user);
        $form = $this->createForm('MatierBundle\Form\EmploiType', $emploi);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $emploi->setEmploit("3.jpg");
            $emploi->getUploadFile();
            $em->persist($emploi);
            $em->flush();
            return $this->redirectToRoute('Emploi_EnseignantAffiche');
        }
        return $this->render('MatierBundle:Emploi:AjouterEmploiEnseignant.html.twig', array(
            'form' => $form->createView(),

        ));
    }


    public function AfficheEnseignantAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("UserBundle:User")->findAll();
        return $this->render('MatierBundle:Emploi:AffichierEnseignant.html.twig', array(
            'ens' => $ense,
        ));
    }


    public function AjouterEmploiClassAction( \Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $emploi = new Emploi();
        $Classe= $em->getRepository("ClasseBundle:Classe")->find(array('id'=>$id));

        $emploi->setClasse($Classe);
        $form = $this->createForm('MatierBundle\Form\EmploiType', $emploi);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $emploi->setEmploit("3.jpg");
            $emploi->getUploadFile();
            $em->persist($emploi);
            $em->flush();
            return $this->redirectToRoute('Emploi_ClasseAffiche');
        }
        return $this->render('MatierBundle:Emploi:AjouterEmploiClasse.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function AfficheEmploiEnseignantAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("MatierBundle:Emploi")->findAll();
        return $this->render('MatierBundle:Emploi:AffichierEmploiEnseignant.html.twig', array(
            'empl' => $ense,
        ));
    }

    public function AfficheEmploiEnseignantbackAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("MatierBundle:Emploi")->findBy(array('user'=>$this->getUser()->getId()));
        return $this->render('MatierBundle:Emploi:AffichierEmploiEnseignantback.html.twig', array(
            'empl' => $ense,
        ));
    }

    public function deleteEmploiEnseignantAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Emploi = $em->getRepository('MatierBundle:Emploi')->find($id);
        $em->remove($Emploi);
        $em->flush();


        return $this->redirectToRoute('Emploi_Enseigant');
    }


    public function AfficheEmploiClassAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("MatierBundle:Emploi")->findAll();
        return $this->render('MatierBundle:Emploi:AffichierEmploiClass.html.twig', array(
            'empl' => $ense,
        ));
    }


    public function deleteEmploiClassAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Emploi = $em->getRepository('MatierBundle:Emploi')->find($id);
        $em->remove($Emploi);
        $em->flush();


        return $this->redirectToRoute('Emploi_ClasseAffiche');
    }



}
