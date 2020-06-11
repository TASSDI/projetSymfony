<?php

namespace MonLivreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class VoteController extends Controller
{
    public function rateAction(\Symfony\Component\HttpFoundation\Request $request){
        $data = $request->getContent();
        $obj = json_decode($data,true);

        $em = $this->getDoctrine()->getManager();
        $rate =$obj['rate'];
        $idc = $obj['monlivre'];
        $monLivre = $em->getRepository("MonLivreBundle:Matieremonlivre")->find($idc);
        $note = ($monLivre->getRate()*$monLivre->getVote() + $rate)/($monLivre->getVote()+1);
        $monLivre->setVote($monLivre->getVote()+1);
        $monLivre->setRate($note);
        $em->persist($monLivre);
        $em->flush();
        return new Response($monLivre->getRate());
    }
}
