<?php

namespace ClasseBundle\Controller;

use ClasseBundle\Entity\Absence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbsenceController extends Controller
{
    public function AjouterAbsenceAction($id ,$idu)
    {
        $em = $this->getDoctrine()->getManager();
        $absence= $em->getRepository("ClasseBundle:Absence")->findOneBy(array("apprenant"=>$idu));
        $absence->setNbAbsence($absence->getNbAbsence()+1);
        $em->persist($absence);
        $em->flush();
        return $this->redirectToRoute('AffechierAffecter', ['id' => $id]);

    }

    public function AfficheEnfantParnetAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $affecter= $m->getRepository("UserBundle:User")->findBy(array("parent"=> $this->getUser()->getId()));
        return $this->render('ClasseBundle:Front:AffichierEnfantParent.html.twig', array(
            'class' => $affecter,
        ));
    }

    public function AfficheParnetNoteEnfantAction(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $m = $this->getDoctrine()->getManager();
        $note= $m->getRepository("ClasseBundle:Note")->findBy(array("apprenant"=>$id ));
        $user =$m->getRepository("ClasseBundle:Affecter")->findOneBy(array("user"=>$id ));
        $emploi =$m->getRepository("MatierBundle:Emploi")->findAll();
        $absence= $m->getRepository("ClasseBundle:Absence")->findOneBy(array("apprenant"=>$id ));

        return $this->render('ClasseBundle:Front:AffichierNoteParent.html.twig', array(
            'note' => $note,
            'absence'=>$absence,
            'emploi'=>$emploi,
            'user'=>$user

        ));
    }


    public function AfficheMonInfoAction(\Symfony\Component\HttpFoundation\Request $request )
    {
        $m = $this->getDoctrine()->getManager();
        $id=$this->getUser()->getId();
        $note= $m->getRepository("ClasseBundle:Note")->findBy(array("apprenant"=>$id ));
        $user =$m->getRepository("ClasseBundle:Affecter")->findOneBy(array("user"=>$id ));
        $emploi =$m->getRepository("MatierBundle:Emploi")->findAll();
        $absence= $m->getRepository("ClasseBundle:Absence")->findOneBy(array("apprenant"=>$id ));

        return $this->render('ClasseBundle:Front:AffichierMyInfo.html.twig', array(
            'note' => $note,
            'absence'=>$absence,
            'emploi'=>$emploi,
            'user'=>$user

        ));
    }

}
