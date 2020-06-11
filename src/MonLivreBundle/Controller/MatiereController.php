<?php

namespace MonLivreBundle\Controller;

use Composer\DependencyResolver\Request;
use MonLivreBundle\Entity\Matieremonlivre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MatiereController extends Controller
{

    public function AjoutMatiereAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Matiere = new Matieremonlivre();
        $form = $this->createForm('MonLivreBundle\Form\MatieremonlivreType', $Matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Matiere->setNomfile("3.jpg");
            $Matiere->getUploadFile();
            $em->persist($Matiere);
            $em->flush();

            //return $this->redirectToRoute('categorie_Affiche');
        }
        return $this->render('MonLivreBundle:Matiere:AjoutMatier.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function AfficheMatiereAction(\Symfony\Component\HttpFoundation\Request $request)
    {


        $m = $this->getDoctrine()->getManager();
        $Matiere = $m->getRepository("MonLivreBundle:Matieremonlivre")->findAll();

        return $this->render('MonLivreBundle:Matiere:AfficherMatiere.html.twig', array(
            'mat' => $Matiere
        ));
    }


    public function deleteMatiereAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $matiere = $em->getRepository('MonLivreBundle:Matieremonlivre')->find($id);
        $em->remove($matiere);
        $em->flush();


        return $this->redirectToRoute('Affichier_MatierLivre');
    }

    public function ModifierMatierAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $classe = $em->getRepository('MonLivreBundle:Matieremonlivre')->find($id);
        $editForm = $this->createForm('MonLivreBundle\Form\MatieremonlivreType', $classe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('Affichier_MatierLivre');
        }

        return $this->render('MonLivreBundle:Matiere:ModifierMatiere.html.twig', array(
            'form' => $editForm->createView(),
        ));
    }

    public function AfficheMatiereFrontAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $count = $this->count();
        $m = $this->getDoctrine()->getManager();
        $Matiere = $m->getRepository("MonLivreBundle:Matieremonlivre")->findAll();

        return $this->render('MonLivreBundle:Front:AfficherMatiereFront.html.twig', array(
            'mat' => $Matiere ,
            'c' =>$count
        ));
    }

    public function AfficheMatiereFrontDétailsAction(\Symfony\Component\HttpFoundation\Request $request ,$id)
    {


        $m = $this->getDoctrine()->getManager();
        $Matiere = $m->getRepository("MonLivreBundle:Matieremonlivre")->find(array('id'=>$id));
        $monLivre = $m->getRepository("MonLivreBundle:Monlivre")->findBy(array('matiere'=>$id));

        $resev  = $m->getRepository('MonLivreBundle:Inscription')->findBy(array('idUser'=>$this->getUser()->getId(),
            'matiere'=>$id));
        return $this->render('MonLivreBundle:Front:AfficherMatiereDetailsFront.html.twig', array(
            'mat' => $Matiere,
            'insc'=>$resev,
            'livre'=>$monLivre
        ));
    }

    public function count()
    {
        $count = 0;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MonLivreBundle:Inscription")->findBy(array('idUser'=>$this->getUser()->getId()));
        foreach ($commentaire as $e){
            $count = $count + 1;
        }

        return $count;

    }
}
