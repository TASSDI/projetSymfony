<?php

namespace MatierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Cour
 *
 * @ORM\Table(name="cour", indexes={@ORM\Index(name="matiere", columns={"matiere"}), @ORM\Index(name="classe", columns={"classe"})})
 * @ORM\Entity
 */
class Cour
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
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=100, nullable=true)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="cour_pdf", type="text", length=65535, nullable=false)
     */
    private $courPdf;

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
     * @var \MatierBundle\Entity\Matiere
     *
     * @ORM\ManyToOne(targetEntity="\MatierBundle\Entity\Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matiere", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $matiere;


    public function getWebpath(){


        return null === $this->courPdf ? null : $this->getUploadDir.'/'.$this->courPdf;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../web/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->courPdf = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->courPdf = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;

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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getCourPdf()
    {
        return $this->courPdf;
    }

    /**
     * @param string $courPdf
     */
    public function setCourPdf($courPdf)
    {
        $this->courPdf = $courPdf;
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



}

