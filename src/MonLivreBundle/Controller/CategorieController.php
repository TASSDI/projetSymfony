<?php

namespace MonLivreBundle\Controller;

use MonLivreBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    public function AjoutCategorieAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie();
        $form = $this->createForm('MonLivreBundle\Form\CategorieType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('categorie_Affiche');
        }
        return $this->render('MonLivreBundle:Categorie:AjoutCategorie.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function AfficheCategorieAction(Request $request)
    {


        $m = $this->getDoctrine()->getManager();
        $Categorie = $m->getRepository("MonLivreBundle:Categorie")->findAll();

        return $this->render('MonLivreBundle:Categorie:AfficherCategorie.html.twig', array(
            'cat' => $Categorie
        ));
    }

    public function deleteCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $Categorie = $em->getRepository('MonLivreBundle:Categorie')->find($id);
        $em->remove($Categorie);
        $em->flush();


        return $this->redirectToRoute('categorie_Affiche');
    }
}
