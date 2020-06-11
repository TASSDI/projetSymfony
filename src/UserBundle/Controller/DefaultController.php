<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
    public function ParentAction()
    {
        $m = $this->getDoctrine()->getManager();
        $Categorie = $m->getRepository("MonLivreBundle:Categorie")->findAll();

        return $this->render('UserBundle::Page_Parent.html.twig', array(
            'cat' => $Categorie
        ));
    }


    public function ApprenantAction()
    {
        $m = $this->getDoctrine()->getManager();
        $Categorie = $m->getRepository("MonLivreBundle:Categorie")->findAll();

        return $this->render('UserBundle::Page_Apprenant.html.twig', array(
            'cat' => $Categorie
        ));

    }
    public function EmplyoerAction()
    {
        return $this->render('UserBundle::Page_Employer.html.twig');
    }

    public function EnseignantAction()
    {
        return $this->render('UserBundle::Page_Enseignant.html.twig');
    }

    public function AdminAction()
    {
        return $this->render('UserBundle::Page_Admin.html.twig');
    }



    public function AjouterApprenantAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm('UserBundle\Form\EnfantForm', $user);
        $us = $em->getRepository('UserBundle:User')->find(array("id" => $this->getUser()->getId()));
        $user->setRoles(array('ROLE_APPRENANT'));
        $user->setParent($us);
        $user->setCin($us->getCin());
        $user->setEnabled(true);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('Front');
        }
        return $this->render('UserBundle::AjoutMonEnfant.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function AjouterEmployerAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm('UserBundle\Form\EmployerType', $user);
        $user->setRoles(array('ROLE_EMPLOYER'));
        $user->setEnabled(true);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();
           return $this->redirectToRoute('Affichier_user');
        }
        return $this->render('UserBundle:Admin:AjoutEmployer.html.twig', array(
            'form' => $form->createView(),

        ));
    }


    public function AjouterEnseigantAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm('UserBundle\Form\EnseignantForm', $user);
        $user->setRoles(array('ROLE_ENSEIGNANT'));
        $user->setEnabled(true);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();
             return $this->redirectToRoute('Affichier_user');
        }
        return $this->render('UserBundle:Admin:AjoutEnseignant.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function AfficheUserAction()
    {


        $m = $this->getDoctrine()->getManager();
        $user= $m->getRepository("UserBundle:User")->findAll();


        return $this->render('UserBundle:Admin:AfficherUser.html.twig', array(
            'user' => $user
        ));
    }




}
