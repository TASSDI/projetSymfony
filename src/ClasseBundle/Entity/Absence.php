<?php

namespace ClasseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\UserBundle;

/**
 * Absence
 *
 * @ORM\Table(name="absence", indexes={@ORM\Index(name="cour", columns={"classe"}), @ORM\Index(name="apprenant", columns={"apprenant"})})
 * @ORM\Entity
 */
class Absence
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
     * @var integer
     *
     * @ORM\Column(name="nb_absence", type="integer", nullable=false)
     */
    private $nbAbsence;

    /**
     * @var \ClasseBundle\Entity\Classe
     *
     * @ORM\ManyToOne(targetEntity="ClasseBundle\Entity\Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classe", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $classe;

    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="apprenant", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $apprenant;

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
     * @return int
     */
    public function getNbAbsence()
    {
        return $this->nbAbsence;
    }

    /**
     * @param int $nbAbsence
     */
    public function setNbAbsence($nbAbsence)
    {
        $this->nbAbsence = $nbAbsence;
    }

    /**
     * @return \ClasseBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param \ClasseBundle\Entity\Classe $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }

    /**
     * @return \UserBundle\Entity\User
     */
    public function getApprenant()
    {
        return $this->apprenant;
    }

    /**
     * @param User $apprenant
     */
    public function setApprenant($apprenant)
    {
        $this->apprenant = $apprenant;
    }




}

