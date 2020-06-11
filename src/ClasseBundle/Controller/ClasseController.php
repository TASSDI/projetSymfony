<?php

namespace ClasseBundle\Controller;

use ClasseBundle\Entity\Absence;
use ClasseBundle\Entity\Affecter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClasseBundle\Entity\Classe;

class ClasseController extends Controller
{
    public function AjouterClassAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = new Classe();
        $form = $this->createForm('ClasseBundle\Form\ClasseType', $classe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute('classe_Afficher');
        }
        return $this->render('ClasseBundle:Classe:AjoutClasse.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function AfficheClasseAction()
    {


        $m = $this->getDoctrine()->getManager();
        $Classe= $m->getRepository("ClasseBundle:Classe")->findAll();


        return $this->render('ClasseBundle:Classe:AfficherClasse.html.twig', array(
            'class' => $Classe
        ));
    }

    public function deleteClasseAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $class = $em->getRepository('ClasseBundle:Classe')->find($id);
        $em->remove($class);
        $em->flush();


        return $this->redirectToRoute('classe_Afficher');
    }

    public function ModifierClasseAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $classe = $em->getRepository('ClasseBundle:Classe')->find($id);
        $editForm = $this->createForm('ClasseBundle\Form\ClasseType', $classe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('classe_Afficher');
        }

        return $this->render('ClasseBundle:Classe:ModifierClasse.html.twig', array(
            'form' => $editForm->createView(),
        ));
    }


    public function  AllUserAction()
    {


        $m = $this->getDoctrine()->getManager();
        $User= $m->getRepository("UserBundle:User")->findAll();


        return $this->render('ClasseBundle:Classe:AllUser.html.twig', array(
            'user' => $User
        ));
    }

    public function AfficheClassebyNiveauAction(\Symfony\Component\HttpFoundation\Request $request , $id)
    {


        $m = $this->getDoctrine()->getManager();
        $User= $m->getRepository("UserBundle:User")->find(array("id"=>$id));
        $niveau = $User->getNiveau();
        $Classe= $m->getRepository("ClasseBundle:Classe")->findBy(array("niveau"=>$niveau));


        return $this->render('ClasseBundle:Classe:AfficherClasseByNiveau.html.twig', array(
            'class' => $Classe,
            'user'=>$User
        ));
    }

    public function AffecterClassAction( \Symfony\Component\HttpFoundation\Request $request,$idc,$idu)
    {
        $em = $this->getDoctrine()->getManager();
        $affect = new Affecter();
        $Abscence = new Absence();

        $classe= $em->getRepository("ClasseBundle:Classe")->find(array("id"=>$idc));
        $User= $em->getRepository("UserBundle:User")->find(array("id"=>$idu));
        $Abscence->setApprenant($User);
        $Abscence->setClasse($classe);
        $Abscence->setNbAbsence(0);
        $User->setAffecter(1);

        $affect->setUser($User);
        $affect->setClasse($classe);
        $em->persist($Abscence);
        $em->persist($affect);

        $em->flush();
            return $this->redirectToRoute('AllUser');
        }


    public function AfficheClassebyApprenantAction(\Symfony\Component\HttpFoundation\Request $request , $id)
    {
        $m = $this->getDoctrine()->getManager();
        $affecter= $m->getRepository("ClasseBundle:Absence")->findBy(array("classe"=>$id));
        return $this->render('ClasseBundle:Classe:AffichierAffecter.html.twig', array(
            'class' => $affecter,
            'id'=>$id
        ));
    }

    public function deleteAffecterAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $aff = $em->getRepository('ClasseBundle:Affecter')->find($id);
        $Classe= $em->getRepository("ClasseBundle:Classe")->find(array("id"=>$aff->getClasse()));
        $idc=$Classe->getId();


        $em->remove($aff);
        $em->flush();


        return $this->redirectToRoute('AffechierAffecter', ['id' => $aff->getClasse()->getId()]);
    }



}
