<?php

namespace MatierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\UserBundle;

/**
 * Emploi
 *
 * @ORM\Table(name="emploi", indexes={@ORM\Index(name="class", columns={"classe"}), @ORM\Index(name="user", columns={"user"})})
 * @ORM\Entity
 */
class Emploi
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
     * @ORM\Column(name="n_emploi", type="string", length=50, nullable=false)
     */
    private $nEmploi;

    /**
     * @var string
     *
     * @ORM\Column(name="extention", type="string", length=10, nullable=true)
     */
    private $extention;

    /**
     * @var string
     *
     * @ORM\Column(name="emploit", type="text", length=65535, nullable=false)
     */
    private $emploit;

    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $user;

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
    public function getNEmploi()
    {
        return $this->nEmploi;
    }

    /**
     * @param string $nEmploi
     */
    public function setNEmploi($nEmploi)
    {
        $this->nEmploi = $nEmploi;
    }

    /**
     * @return string
     */
    public function getExtention()
    {
        return $this->extention;
    }

    /**
     * @param string $extention
     */
    public function setExtention($extention)
    {
        $this->extention = $extention;
    }

    /**
     * @return string
     */
    public function getEmploit()
    {
        return $this->emploit;
    }

    /**
     * @param string $emploit
     */
    public function setEmploit($emploit)
    {
        $this->emploit = $emploit;
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


    public function getWebpath(){


        return null === $this->emploit ? null : $this->getUploadDir().'/'.$this->emploit;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../web/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->emploit = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->emploit = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;

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

