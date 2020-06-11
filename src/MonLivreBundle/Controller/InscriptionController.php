<?php

namespace MonLivreBundle\Controller;

use MonLivreBundle\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InscriptionController extends Controller
{

    public function AjoutInscriptionAction( \Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $resevation = new Inscription();

        $Cour = $em->getRepository("MonLivreBundle:Matieremonlivre")->find(array('id'=>$id));
        $resevation->setMatiere($Cour);
        $user = $em->getRepository('UserBundle:User')->find(array("id"=>$this->getUser()->getId()));
        $resevation->setIdUser($user);
        $em->persist($Cour);
        $em->persist($resevation);
        $em->flush();
        return $this->redirectToRoute('Front_AfficheMonCourDetails', ['id' => $id]);


    }

    public function deleteParticipationClientAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $resev  = $em->getRepository('MonLivreBundle:Inscription')->findOneBy(array('idUser'=>$this->getUser()->getId(),
            'matiere'=>$id));
        $em->remove($resev);
        $em->flush();
        return $this->redirectToRoute('Front_AfficheMonCourDetails', ['id' => $id]);
    }
}
