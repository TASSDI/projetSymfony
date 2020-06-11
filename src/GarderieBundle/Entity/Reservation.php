<?php

namespace GarderieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="activity_type", columns={"activity_type"}), @ORM\Index(name="nbenfants", columns={"nbenfants"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dateRes", type="string", nullable=false)
     */
    private $dateRes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateGar", type="date", nullable=false)
     */
    private $dateGar;


    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var float
     *
     * @ORM\Column(name="etat", type="string", length=255 , nullable=true)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="notif", type="integer", length=255 , nullable=true)
     */
    private $notif;


    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nbenfants", referencedColumnName="id")
     * })
     */
    private $nbenfants;

    /**
     * @var \GarderieBundle\Entity\Activitie
     *
     * @ORM\ManyToOne(targetEntity="\GarderieBundle\Entity\Activitie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_type", referencedColumnName="id")
     * })
     */
    private $activityType;


    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \GarderieBundle\Entity\Garderie
     *
     * @ORM\ManyToOne(targetEntity="\GarderieBundle\Entity\Garderie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="garderie", referencedColumnName="id")
     * })
     */
    private $garderie;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateRes()
    {
        return $this->dateRes;
    }

    /**
     * @param \DateTime $dateRes
     */
    public function setDateRes($dateRes)
    {
        $this->dateRes = $dateRes;
    }


    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return float
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param float $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \UserBundle\Entity\User
     */
    public function getNbenfants()
    {
        return $this->nbenfants;
    }

    /**
     * @param \UserBundle\Entity\User $nbenfants
     */
    public function setNbenfants($nbenfants)
    {
        $this->nbenfants = $nbenfants;
    }

    /**
     * @return Activitie
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * @param Activitie $activityType
     */
    public function setActivityType($activityType)
    {
        $this->activityType = $activityType;
    }

    /**
     * @return \UserBundle\Entity\User
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param \UserBundle\Entity\User $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return \DateTime
     */
    public function getDateGar()
    {
        return $this->dateGar;
    }

    /**
     * @param \DateTime $dateGar
     */
    public function setDateGar($dateGar)
    {
        $this->dateGar = $dateGar;
    }

    /**
     * @return int
     */
    public function getNotif()
    {
        return $this->notif;
    }

    /**
     * @param int $notif
     */
    public function setNotif($notif)
    {
        $this->notif = $notif;
    }

    /**
     * @return Garderie
     */
    public function getGarderie()
    {
        return $this->garderie;
    }

    /**
     * @param Garderie $garderie
     */
    public function setGarderie($garderie)
    {
        $this->garderie = $garderie;
    }




}

