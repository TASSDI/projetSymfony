<?php

namespace ClasseBundle\Controller;

use ClasseBundle\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends Controller
{
    public function AjouterNoteAction( \Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $note = new Note();
        $form = $this->createForm('ClasseBundle\Form\NoteType', $note);
        $user= $em->getRepository("UserBundle:User")->find(array("id"=>$id));
        $class= $em->getRepository("ClasseBundle:Affecter")->findOneBy(array("user"=>$user->getId()));

        $note->setApprenant($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $note->getNoteEcrit();
            $o=$note->getNoteOrale();
            $m=($e*0.6)+($o*0.4);
            $note->setMoyenne($m);

            $em->persist($note);
            $em->flush();
           return $this->redirectToRoute('AffechierAffecter', ['id' => $class->getClasse()->getId()]);
        }
        return $this->render('ClasseBundle:Note:AjoutNote.html.twig', array(
            'form' => $form->createView(),
            'class'=>  $class
        ));
    }



    public function AfficheNoteAction(\Symfony\Component\HttpFoundation\Request $request , $id)
    {
        $m = $this->getDoctrine()->getManager();
        $note= $m->getRepository("ClasseBundle:Note")->findBy(array("apprenant"=>$id));
        return $this->render('ClasseBundle:Note:AffichierNote.html.twig', array(
            'note' => $note,
        ));
    }

    public function ModifierNoteAction(Request $request, $id,$idc)
    {
        $em = $this->getDoctrine()->getManager();

        $Note = $em->getRepository('ClasseBundle:Note')->find($id);
        $editForm = $this->createForm('ClasseBundle\Form\NoteType', $Note);
        $user= $em->getRepository("UserBundle:User")->find(array("id"=>$idc));
        $class= $em->getRepository("ClasseBundle:Affecter")->findOneBy(array("user"=>$idc));
        $Note->setApprenant($user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $e = $Note->getNoteEcrit();
            $o=$Note->getNoteOrale();
            $m=($e*0.6)+($o*0.4);
            $Note->setMoyenne($m);

            $em->persist($Note);
            $em->flush();

            return $this->redirectToRoute('AfficheNote', ['id' => $idc]);
        }

        return $this->render('ClasseBundle:Note:ModifierNote.html.twig', array(
            'note' => $Note,
            'form' => $editForm->createView(),
        ));
    }



    public function deleteNoteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $aff = $em->getRepository('ClasseBundle:Note')->find($id);
        $user= $em->getRepository("UserBundle:User")->find(array("id"=>$aff->getApprenant()));

        $em->remove($aff);
        $em->flush();
        return $this->redirectToRoute('AfficheNote', ['id' => $user->getId()]);
    }

}
