<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Evenement
 *
 * @ORM\Table(name="evenements")
 *@UniqueEntity(fields="titre", message="Une titre existe déjà avec ce nom.")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\EvenementRepository")
 */
class Evenement
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=200, nullable=false)
     */
    private $titre;

    /**
     *
     * @ORM\Column(name="rate", type="float", nullable=true)
     */
    private $rate;

    /**
     *
     * @ORM\Column(name="vote", type="integer", nullable=true)
     */
    private $vote;

    /**
     * @var string
     *
     * @ORM\Column(name="discription", type="string", length=200, nullable=false)
     */
    private $discription;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="DateDebut", type="date", nullable=false)
     */
    private $dated;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="DateFin", type="date", nullable=false)
     */
    private $dateF;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=200, nullable=false)
     */
    private $lieu;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=200, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbreplaces", type="integer", length=200, nullable=false)
     */
    private $nbrplace;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbreparticipants", type="integer", length=200, nullable=false)
     */
    private $nbrparticipant;



    public function getWebpath(){


        return null === $this->file ? null : $this->getUploadDir().'/'.$this->file;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../web/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->file = "3.jpg";
            return;
        }




        // set the path property to the filename where you've saved the file


        // clean up the file property as you won't need it anymore
        $this->imageFile = null;
    }
    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;


    /**
     * @var string
     *
     * @ORM\Column(name="image",type="string", length=255, nullable=true)
     */
    public $image;




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
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDiscription()
    {
        return $this->discription;
    }

    /**
     * @param string $discription
     */
    public function setDiscription($discription)
    {
        $this->discription = $discription;
    }


    /**
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param string $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return int
     */
    public function getNbrplace()
    {
        return $this->nbrplace;
    }

    /**
     * @param int $nbrplace
     */
    public function setNbrplace($nbrplace)
    {
        $this->nbrplace = $nbrplace;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param mixed $vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
    }

    /**
     * @return string
     */
    public function getIamge()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setIamge($image)
    {
        $this->image = $image;
    }

    /**
     * @return DateTime
     */
    public function getDated()
    {
        return $this->dated;
    }

    /**
     * @param DateTime $dated
     */
    public function setDated($dated)
    {
        $this->dated = $dated;
    }

    /**
     * @return DateTime
     */
    public function getDateF()
    {
        return $this->dateF;
    }

    /**
     * @param DateTime $dateF
     */
    public function setDateF($dateF)
    {
        $this->dateF = $dateF;
    }

    /**
     * @return int
     */
    public function getNbrparticipant()
    {
        return $this->nbrparticipant;
    }

    /**
     * @param int $nbrparticipant
     */
    public function setNbrparticipant($nbrparticipant)
    {
        $this->nbrparticipant = $nbrparticipant;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

