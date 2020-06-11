<?php

namespace MatierBundle\Controller;

use MatierBundle\Entity\Cour;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CourController extends Controller
{

    public function count()
    {
        $count = 0;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MatierBundle:Cour")->findAll() ;
        foreach ($commentaire as $e){
            $count = $count + 1;
        }

        return $count;

    }
    public function AjouterCourAction( \Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $cour = new Cour();
        $class= $em->getRepository("ClasseBundle:Classe")->find(array('id'=>$id));
        $cour->setClasse($class);
        $form = $this->createForm('MatierBundle\Form\CourType', $cour);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cour->setCourPdf("3.jpg");
            $cour->getUploadFile();
            $em->persist($cour);
            $em->flush();
           return $this->redirectToRoute('Affichier_Cour');
        }
        return $this->render('MatierBundle:Cour:AjouterCour.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function AfficheClasseAction()
    {


        $m = $this->getDoctrine()->getManager();
        $Classe= $m->getRepository("ClasseBundle:Classe")->findAll();


        return $this->render('MatierBundle:Cour:AfficherClasse.html.twig', array(
            'class' => $Classe
        ));
    }


    public function AfficheCourAction()
    {


        $m = $this->getDoctrine()->getManager();
        $Cours= $m->getRepository("MatierBundle:Cour")->findAll();


        return $this->render('MatierBundle:Cour:AfficherCour.html.twig', array(
            'cour' => $Cours
        ));
    }

    public function deleteCourAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $matiere = $em->getRepository('MatierBundle:Cour')->find($id);
        $em->remove($matiere);
        $em->flush();


        return $this->redirectToRoute('Affichier_Cour');
    }

    public function ModifierCourAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cours = $em->getRepository('MatierBundle:Cour')->find($id);
        $editForm = $this->createForm('MatierBundle\Form\CourType', $cours);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($cours);
            $em->flush();

            return $this->redirectToRoute('Affichier_Cour');
        }

        return $this->render('MatierBundle:Cour:ModifierCour.html.twig', array(
            'form' => $editForm->createView(),
        ));
    }
        public function AfficheCourFrontAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $count = $this->count();
        $Cours= $m->getRepository("MatierBundle:Cour")->findAll();
        $user =$m->getRepository("ClasseBundle:Affecter")->findOneBy(array("user"=>$this->getUser()->getId() ));
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(
             $Cours, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 2)
         );/*page number*/

        return $this->render('MatierBundle:Front:AfficherCourFront.html.twig', array(
            'cour' => $result,
            'user'=>$user,
            'count'=>$count

        ));
    }


}
