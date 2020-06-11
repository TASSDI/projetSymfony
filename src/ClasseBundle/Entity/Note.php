<?php

namespace ClasseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;



/**
 * Note
 *
 * @ORM\Table(name="note", indexes={@ORM\Index(name="apprenant", columns={"apprenant", "matiere"}), @ORM\Index(name="matiere", columns={"matiere"}), @ORM\Index(name="IDX_CFBDFA14C4EB462E", columns={"apprenant"})})
 * @ORM\Entity
 */
class Note
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
     * @var float
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "La note minimal qui doit saisie est{{ limit }}",
     *      maxMessage = "La note maximum qui doit saisie est {{ limit }}"
     * )
     *
     * @ORM\Column(name="note_orale", type="float", precision=10, scale=0, nullable=false)
     */
    private $noteOrale;

    /**
     * @var float
     *
     * @ORM\Column(name="moyenne", type="float", precision=10, scale=0, nullable=false)
     */
    private $moyenne;

    /**
     * @var float
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "La note minimal qui doit saisie est{{ limit }}",
     *      maxMessage = "La note maximum qui doit saisie est {{ limit }}"
     * )
     *
     * @ORM\Column(name="note_ecrit", type="float", precision=10, scale=0, nullable=false)
     */
    private $noteEcrit;

    /**
     * @var \MatierBundle\Entity\Matiere
     *
     * @ORM\ManyToOne(targetEntity="\MatierBundle\Entity\Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matiere", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $matiere;

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
     * @return float
     */
    public function getNoteOrale()
    {
        return $this->noteOrale;
    }

    /**
     * @param float $noteOrale
     */
    public function setNoteOrale($noteOrale)
    {
        $this->noteOrale = $noteOrale;
    }

    /**
     * @return float
     */
    public function getMoyenne()
    {
        return $this->moyenne;
    }

    /**
     * @param float $moyenne
     */
    public function setMoyenne($moyenne)
    {
        $this->moyenne = $moyenne;
    }

    /**
     * @return float
     */
    public function getNoteEcrit()
    {
        return $this->noteEcrit;
    }

    /**
     * @param float $noteEcrit
     */
    public function setNoteEcrit($noteEcrit)
    {
        $this->noteEcrit = $noteEcrit;
    }

    /**
     * @return \MatierBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * @param \MatierBundle\Entity\Matiere $matiere
     */
    public function setMatiere($matiere)
    {
        $this->matiere = $matiere;
    }

    /**
     * @return \UserBundle\Entity\User
     */
    public function getApprenant()
    {
        return $this->apprenant;
    }

    /**
     * @param \UserBundle\Entity\User $apprenant
     */
    public function setApprenant($apprenant)
    {
        $this->apprenant = $apprenant;
    }


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (stripos($this->getNoteOrale(),10) !== false) {
            $context->buildViolation('Um.. the Bork kinda makes us nervous')
                ->atPath('title')
                ->addViolation();
        }
    }

}

