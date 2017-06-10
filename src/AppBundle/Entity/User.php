<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=64, nullable=false)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="text", length=65535, nullable=true)
     */
    private $imageurl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRegister", type="datetime", nullable=true)
     */
    private $dateregister;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLastLogon", type="datetime", nullable=true)
     */
    private $datelastlogon;

    /**
     * @var string
     *
     * @ORM\Column(name="pesel", type="string", length=11, nullable=true)
     */
    private $pesel;

    /**
     * @var integer
     *
     * @ORM\Column(name="appRoleId", type="integer", nullable=false)
     */
    private $approleid;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set imageurl
     *
     * @param string $imageurl
     *
     * @return User
     */
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    /**
     * Get imageurl
     *
     * @return string
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }

    /**
     * Set dateregister
     *
     * @param \DateTime $dateregister
     *
     * @return User
     */
    public function setDateregister($dateregister)
    {
        $this->dateregister = $dateregister;

        return $this;
    }

    /**
     * Get dateregister
     *
     * @return \DateTime
     */
    public function getDateregister()
    {
        return $this->dateregister;
    }

    /**
     * Set datelastlogon
     *
     * @param \DateTime $datelastlogon
     *
     * @return User
     */
    public function setDatelastlogon($datelastlogon)
    {
        $this->datelastlogon = $datelastlogon;

        return $this;
    }

    /**
     * Get datelastlogon
     *
     * @return \DateTime
     */
    public function getDatelastlogon()
    {
        return $this->datelastlogon;
    }

    /**
     * Set pesel
     *
     * @param string $pesel
     *
     * @return User
     */
    public function setPesel($pesel)
    {
        $this->pesel = $pesel;

        return $this;
    }

    /**
     * Get pesel
     *
     * @return string
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * Set approleid
     *
     * @param integer $approleid
     *
     * @return User
     */
    public function setApproleid($approleid)
    {
        $this->approleid = $approleid;

        return $this;
    }

    /**
     * Get approleid
     *
     * @return integer
     */
    public function getApproleid()
    {
        return $this->approleid;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
