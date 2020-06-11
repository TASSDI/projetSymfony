<?php

namespace MatierBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Twilio\Rest\Client;

class UserController extends Controller
{
    public function AfficheAllUserAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("UserBundle:User")->findAll();
        return $this->render('MatierBundle:User:AfficherUser.html.twig', array(
            'user' => $ense,
        ));
    }
    public function BloqueUserAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("UserBundle:User")->find($id);
        $ense->setEnabled(false);
        $sid    = "AC3cf2755d15ea0d041a765459dc10c0c2";
        $token  = "e8a455d0b063c9a092ab4f974a918055";
        $client = new Client($sid, $token);
        $message = $client->messages->create(
            '+21650266100', // Text this number
            [
                'from' => '+18142941818', // From a valid Twilio number
                'body' => 'vous etes bloquer !'
            ]
        );
        $m->persist($ense);
        $m->flush();

        //get an instance of \Service_Twilio

        //return new Response($message->sid);

        //get an instance of \Service_Twilio

        return $this->redirectToRoute('AllUser_affiche');

    }

    public function DebloquerUserAction(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $m = $this->getDoctrine()->getManager();
        $ense= $m->getRepository("UserBundle:User")->find($id);
        $ense->setEnabled(true);

        $sid    = "AC3cf2755d15ea0d041a765459dc10c0c2";
        $token  = "e8a455d0b063c9a092ab4f974a918055";
        $client = new Client($sid, $token);
        $message = $client->messages->create(
            '+21650266100', // Text this number
            [
                'from' => '+18142941818', // From a valid Twilio number
                'body' => 'vous etes debloquer !'
            ]
        );
        $m->persist($ense);
        $m->flush();

        return $this->redirectToRoute('AllUser_affiche');

    }

    public function callAction()
    {
        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
    }


}
