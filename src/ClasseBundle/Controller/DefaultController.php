<?php

namespace ClasseBundle\Controller;

use EvenementBundle\Entity\Commentaire;
use EvenementBundle\Entity\Evenement;
use GarderieBundle\Entity\Activitie;
use GarderieBundle\Entity\Garderie;
use GarderieBundle\Entity\Reservation;

use MatierBundle\Entity\Matiere;
use MonLivreBundle\Entity\Categorie;
use MonLivreBundle\Entity\Inscription;
use MonLivreBundle\Entity\Matieremonlivre;
use MonLivreBundle\Entity\Monlivre;
use MonLivreBundle\MonLivreBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClasseBundle:Default:index.html.twig');
    }

    public function ListeMatiereAction()
    {
        $matier = $this->getDoctrine()->getRepository(Inscription::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['inscription' => $matier]);
        return new JsonResponse($formatted);
    }

    public function listeCtegorieAction()
    {
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['categorie' => $categorie]);
        return new JsonResponse($formatted);
    }

    public function listeLivresAction($id)
    {
        $matierelivre = $this->getDoctrine()->getRepository(Matieremonlivre::class)->find($id);
        $categorie = $this->getDoctrine()->getRepository(Monlivre::class)->findBy(array('matiere' => $matierelivre));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['Livre' => $categorie]);
        return new JsonResponse($formatted);
    }

    public function listematiereLivresAction($id)
    {
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $categorie = $this->getDoctrine()->getRepository(Matieremonlivre::class)->findBy(array('Categorie' => $categorie));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['Matieremonlivre' => $categorie]);
        return new JsonResponse($formatted);
    }

    public function checkifsubscribedAction($iduser, $idmatieremonlivre)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $matierelivre = $this->getDoctrine()->getRepository(Matieremonlivre::class)->find($idmatieremonlivre);
        $inscription = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array('matiere' => $matierelivre, 'idUser' => $user));
        $n = count($inscription);
        if ($n == 0) {
            return new Response("Not subscribed");
        } else {
            return new Response("subscribed");
        }

    }

    public function ActivityListAction()
    {
        $activite = $this->getDoctrine()->getRepository(Activitie::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['activite' => $activite]);
        return new JsonResponse($formatted);

    }

    public function ListEnfantsAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $enfants = $this->getDoctrine()->getRepository(User::class)->findBy(array('parent' => $user));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['Enfant' => $enfants]);
        return new JsonResponse($formatted);
    }

    public function ListReservationAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('parent' => $user));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['reservation' => $reservation]);
        return new JsonResponse($formatted);
    }

    public function AddReservationAction(Request $request)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('parent'));
        $enfant = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('username' => $request->get('enfant')));
        $activite = $this->getDoctrine()->getRepository(Activitie::class)->findOneBy(array('type' => $request->get('activite')));
        $garderie = $this->getDoctrine()->getRepository(Garderie::class)->findOneBy(array('nom'=>$request->get('garderie')));
        $dategarderie = new \DateTime($request->get('date'));
        $re = $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('parent' => $user));
        $n = count($re);
        $date = new \DateTime("now");
        $reservation = new Reservation();
        $reservation->setParent($user);
        $reservation->setNbenfants($enfant);
        $reservation->setActivityType($activite);
        $reservation->setDateGar($dategarderie);
        $reservation->setGarderie($garderie);
        $reservation->setDateRes($date->format("Y-m-d"));

        $reservation->setEtat("En attente");
        if($n > 3){
            $reservation->setPrix($activite->getPrix()+20);
        }else{
            $prix = $activite->getPrix() +20 ;
            $remise = (($prix*20)/100);
            $reservation->setPrix($prix - $remise);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        return new Response("Done");
    }

    public function ListEventsAction()
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->findBy(array('type'=>"Event"));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['Events' => $events]);
        return new JsonResponse($formatted);
    }

    public function CommentsCountAction($id)
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $comment = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(array('idevenement' => $events));
        return new Response(count($comment));

    }

    public function CommentsListAction($id)
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $comment = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(array('idevenement' => $events));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['Comments' => $comment]);
        return new JsonResponse($formatted);

    }

    public function AddCommentaireAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->find($request->get('event'));
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('user'));
        $commentaire = new Commentaire();
        $commentaire->setCommentaire($request->get('commentaire'));
        $commentaire->setIdUser($user);
        $commentaire->setIdevenement($events);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->flush();
        return new Response("Done");

    }

    public function ParticiperAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->find($request->get('event'));
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('user'));
        $commentaire = new \EvenementBundle\Entity\Reservation();

        $commentaire->setIdUser($user);
        $commentaire->setIdevenement($events);
        $events->setNbrparticipant($events->getNbrparticipant()+1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->persist($events);
        $em->flush();
        return new Response("Done");
    }

    public function checkIfPartAction($iduser, $idevent)
    {

        $events = $this->getDoctrine()->getRepository(Evenement::class)->find($idevent);


        $user = $this->getDoctrine()->getRepository(User::class)->find($iduser);
        $part = $this->getDoctrine()->getRepository(\EvenementBundle\Entity\Reservation::class)->findBy(array('idevenement' => $events, 'idUser' => $user));
        $n = count($part);
        if ($n == 0) {
            return new Response("Not subscribed");
        } else {
            return new Response("subscribed");
        }

    }
    public function InscriAction($iduser,$idmatiere){
        $user =$this->getDoctrine()->getRepository(User::class)->find($iduser);
        $matiere = $this->getDoctrine()->getRepository(Matieremonlivre::class)->find($idmatiere);
        $inscr = new Inscription();
        $inscr->setIdUser($user);
        $inscr->setMatiere($matiere);
        $em = $this->getDoctrine()->getManager();
        $em->persist($inscr);
        $em->flush();
        return new Response("Done");
    }
    public function AnnulerReservationAction($id){
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);
        $reservation->setEtat("Annulée");
        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();
        return new Response("Done");

    }
    public function countNotifAction($id){
        $user =$this->getDoctrine()->getRepository(User::class)->find($id);
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('parent'=>$user,'notif'=>0));
        $n = count($reservation);
        return new Response($n);
    }
    public function getnotifAction($id){
        $user =$this->getDoctrine()->getRepository(User::class)->find($id);
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('parent'=>$user,'notif'=>0));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['reservation' => $reservation]);
        return new JsonResponse($formatted);

    }
    public function CheckNotifAction($id){
        $user =$this->getDoctrine()->getRepository(User::class)->find($id);
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('parent'=>$user,'notif'=>0));
        foreach ($reservation as $a){
            $em = $this->getDoctrine()->getManager();
            $a->setNotif(1);
            $em->persist($a);
            $em->flush();
        }
        return new Response("Done");

    }
    public function listeGarderieAction(){
        $garderie = $this->getDoctrine()->getRepository(Garderie::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['garderie' => $garderie]);
        return new JsonResponse($formatted);
    }
    public function AjouterRateAction(Request $request){
        $garderie = $this->getDoctrine()->getRepository(Garderie::class)->find($request->get('id'));
        $garderie->setNote(($request->get('note')+$garderie->getNote())/2);
        $em =$this->getDoctrine()->getManager();
        $em->persist($garderie);
        $em->flush();
        return new Response("Done");
    }
    public function ListActiviteAction()
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->findBy(array('type'=>"Activité"));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['Events' => $events]);
        return new JsonResponse($formatted);
    }
    public function AddEnfantAction(Request $request){
        $user = new User();
        $user->setEnabled(1);
        $user->setUsername($request->get('username'));
        $user->setPrenom($request->get('prenom'));
        $user->setEmail($request->get('email'));
        $user->setUsernameCanonical($request->get('username'));
        $user->setEmailCanonical($request->get('email'));
        $user->setTel($request->get('tel'));
        $user->setSexe($request->get('sexe'));
        $user->setNiveau($request->get('niveau'));
        $user->setCin(12345678);
        $user->setRoles(array('ROLE_APPRENANT'));
        $d = new \DateTime($request->get('date'));
        $user->setDateNaissance($d);
        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $request->get('password'));
        $user->setPassword($password);
        $u = $this->getDoctrine()->getRepository(User::class)->find($request->get('user'));
        $user->setParent($u);
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new Response("Done");
    }
    public function unParticiperAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository(Evenement::class)->find($request->get('event'));
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('user'));
        $commentaire = $this->getDoctrine()->getRepository(\EvenementBundle\Entity\Reservation::class)->findOneBy(array('idUser'=>$user,'idevenement'=>$events));


        $events->setNbrparticipant($events->getNbrparticipant()-1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($events);
        $em->remove($commentaire);
        $em->flush();
        return new Response("Done");
    }
    public function searchByChiledNameAction($prenom){
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('username'=>$prenom));
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('nbenfants'=>$user));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize(['reservation' => $reservation]);
        return new JsonResponse($formatted);
    }

    public function LikeAction($id){
        $event = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $event->setVote($event->getVote()+1);
        $em= $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        return new Response("Done");
    }
}
