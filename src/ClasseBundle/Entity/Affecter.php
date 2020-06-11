<?php

namespace ClasseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affecter
 *
 * @ORM\Table(name="affecter")
 * @ORM\Entity(repositoryClass="ClasseBundle\Repository\AffecterRepository")
 */
class Affecter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @var \ClasseBundle\Entity\Classe
     *
     * @ORM\ManyToOne(targetEntity="\ClasseBundle\Entity\Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classe", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $classe;


    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $user;

    /**
     * @return Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param Classe $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }

    /**
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \UserBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



}

