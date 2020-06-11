<?php

namespace GarderieBundle\Controller;

use GarderieBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ReservationController extends Controller
{

    public function AjouterReservationAction( \Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $id=$this->getUser()->getId();
        $date = (date('Y-m-d'));
        $reservation->setDateRes($date);
        $user = $em->getRepository('UserBundle:User')->find(array("id" => $this->getUser()->getId()));
        $reservation->setParent($user);
        $reservation->setEtat("En cours");
        $form = $this->createForm('GarderieBundle\Form\ReservationType',$reservation,['id'=>$id]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $prix=$reservation->getActivityType()->getPrix()+20;
            $reservation->setPrix($prix);
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('Reservation_affichFront');
        }
        return $this->render('GarderieBundle:Front:ReserverGarderie.html.twig', array(
            'form' => $form->createView(),


        ));
    }

    public function AfficheMyReservAction()
    {


        $m = $this->getDoctrine()->getManager();
        $user = $m->getRepository('UserBundle:User')->find(array("id" => $this->getUser()->getId()));
        $reservation= $m->getRepository("GarderieBundle:Reservation")->findBy(array('parent'=>$user));


        return $this->render('GarderieBundle:Front:MyReservation.html.twig', array(
            'res' => $reservation
        ));
    }

    public function AfficheAllReservAction()
    {


        $m = $this->getDoctrine()->getManager();
        $reservation= $m->getRepository("GarderieBundle:Reservation")->findAll();


        return $this->render('GarderieBundle:Reservation:AllReservation.html.twig', array(
            'res' => $reservation
        ));
    }

    public function AccepterReserAction($id)
    {


        $m = $this->getDoctrine()->getManager();
        $reservation= $m->getRepository("GarderieBundle:Reservation")->find(array('id'=>$id));
        $user= $m->getRepository("UserBundle:User")->findOneBy(array('id'=>$id));

        $message =  \Swift_Message::newInstance()
            ->setSubject('Garderie')
            ->setFrom('edsmart1997@gmail.com')
            ->setTo($reservation->getParent()->getEmail())
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/mail.html.twig',
                    array('nom' => $reservation->getParent()->getUsername(), 'prenom'=>$reservation->getParent()->getPrenom(),
                      'date'=>  $reservation->getDateGar(),'prix'=>$reservation->getActivityType()->getPrix(),
                        'nomEnfant'=>$reservation->getNbenfants()->getUsername(),
                        'total'=>$reservation->getPrix()

                        )


                ),
                'text/html'
            );
        $this->get('mailer')->send($message);


        // you can remove the following code if you don't define a text version for your emails
        $reservation->setNotif(0);
        $reservation->setEtat("Accepter");
        $m->persist($reservation);
        $m->flush();
        return $this->redirectToRoute('ArchiveRes');


    }

    public function RefuserReserAction($id)
    {


        $m = $this->getDoctrine()->getManager();
        $reservation= $m->getRepository("GarderieBundle:Reservation")->find(array('id'=>$id));
        $message =  \Swift_Message::newInstance()
            ->setSubject('Garderie')
            ->setFrom('edsmart1997@gmail.com')
            ->setTo($reservation->getParent()->getEmail())
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/mailRef.html.twig',
                    array('nom' => $reservation->getParent()->getUsername(), 'prenom'=>$reservation->getParent()->getPrenom(),
                        'date'=>  $reservation->getDateGar(),'prix'=>$reservation->getActivityType()->getPrix(),
                        'nomEnfant'=>$reservation->getNbenfants()->getUsername(),
                        'total'=>$reservation->getPrix()

                    )


                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        $reservation->setNotif(0);
        $reservation->setEtat("Refuser");
        $m->persist($reservation);
        $m->flush();

        return $this->redirectToRoute('ArchiveRes');


    }


    public function AfficheArchiveReservAction()
    {


        $m = $this->getDoctrine()->getManager();
        $reservation= $m->getRepository("GarderieBundle:Reservation")->findAll();


        return $this->render('GarderieBundle:Reservation:ArchiveGard.html.twig', array(
            'res' => $reservation
        ));
    }

    public function deleteReservationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $reserver = $em->getRepository('GarderieBundle:Reservation')->find($id);
        $em->remove($reserver);
        $em->flush();


        return $this->redirectToRoute('Reservation_affichFront');
    }


    public function ModifierReservationAction( \Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('GarderieBundle:Reservation')->find($id);
        $id=$this->getUser()->getId();
        $date = (date('Y-m-d'));
        $reservation->setDateRes($date);
        $user = $em->getRepository('UserBundle:User')->find(array("id" => $this->getUser()->getId()));
        $reservation->setParent($user);
        $reservation->setEtat("En cours");
        $form = $this->createForm('GarderieBundle\Form\ReservationType',$reservation,['id'=>$id]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $prix=$reservation->getActivityType()->getPrix()+20;
            $reservation->setPrix($prix);
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('Reservation_affichFront');
        }
        return $this->render('GarderieBundle:Front:ReserverGarderie.html.twig', array(
            'form' => $form->createView(),


        ));
    }



}
