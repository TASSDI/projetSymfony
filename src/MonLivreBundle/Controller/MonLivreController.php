<?php

namespace MonLivreBundle\Controller;

use MonLivreBundle\Entity\Monlivre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MonLivreController extends Controller
{

    public function AjoutMCourLivreAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Matiere = new Monlivre();
        $form = $this->createForm('MonLivreBundle\Form\MonlivreType', $Matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Matiere->getVideo("3.jpg");
            $Matiere->getUploadFile();
            $em->persist($Matiere);
            $em->flush();
            return $this->redirectToRoute('CourMonLivre_Affichier');
        }
        return $this->render('MonLivreBundle:Monlivre:AjoutCourMonLivre.html.twig', array(
            'form' => $form->createView(),
        ));

    }

        public function AfficheMonLivreAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $Categorie = $m->getRepository("MonLivreBundle:Monlivre")->findAll();

        return $this->render('MonLivreBundle:Monlivre:AfficherMonLivre.html.twig', array(
            'cour' => $Categorie
        ));
    }

    public function deleteMonLivreAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Categorie = $em->getRepository('MonLivreBundle:Monlivre')->find($id);
        $em->remove($Categorie);
        $em->flush();


        return $this->redirectToRoute('CourMonLivre_Affichier');
    }

    public function ModifierCourAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cours = $em->getRepository('MonLivreBundle:Monlivre')->find($id);
        $editForm = $this->createForm('MonLivreBundle\Form\MonlivreTypeEdit', $cours);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($cours);
            $em->flush();

            return $this->redirectToRoute('CourMonLivre_Affichier');
        }

        return $this->render('MonLivreBundle:Monlivre:ModifierMonLivre.html.twig', array(
            'form' => $editForm->createView(),
        ));
    }




}
