<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VoteController extends Controller
{
    public function LikeAction(Request $request,$id)
    {
        // $count = $this->count($id);
        $em = $this->getDoctrine()->getManager();
        $vote = new Vote();
        $comment = $em->getRepository("EvenementBundle:Evenement")->find(array("id" => $id));
        $user  = $em->getRepository('UserBundle:User')->find(array('id'=>$this->getUser()->getId()));
        $like  = $em->getRepository('EvenementBundle:Vote')->findOneBy(array('idClient'=>$this->getUser()->getId(),'idEvenement'=>$id));

        if ($like != null) {

            $vote->setIdClient($user);
            $vote->setIdEvenement($comment);
            $vote->setType(1);
            $em->remove($like);
            $em->persist($vote);
            $em->flush();
        }
        else{

            $vote->setIdClient($user);
            $vote->setIdEvenement($comment);
            $vote->setType(1);
            $em->persist($vote);
            $em->flush();

        }
        return $this->redirectToRoute('Comment', ['id' => $id]);
    }

    public function DesLikeAction(Request $request,$id)
    {
        // $count = $this->count($id);
        $em = $this->getDoctrine()->getManager();
        $vote = new Vote();
        $comment = $em->getRepository("EvenementBundle:Evenement")->find(array("id" => $id));
        $user  = $em->getRepository('UserBundle:User')->find(array('id'=>$this->getUser()->getId()));

        $like  = $em->getRepository('EvenementBundle:Vote')->findOneBy(array('idClient'=>$this->getUser()->getId(),'idEvenement'=>$id));

        if ($like != null) {

            $vote->setIdClient($user);
            $vote->setIdEvenement($comment);
            $vote->setType(2);
            $em->remove($like);
            $em->persist($vote);
            $em->flush();
        }
        else{

            $vote->setIdClient($user);
            $vote->setIdEvenement($comment);
            $vote->setType(2);
            $em->persist($vote);
            $em->flush();

        }
        return $this->redirectToRoute('Comment', ['id' => $id]);
    }

}
