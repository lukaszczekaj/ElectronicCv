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
     * @ORM\Column(name="firstName", type="string", length=100, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=100, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="text", length=65535, nullable=true)
     */
    private $imageurl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRegister", type="datetime", nullable=false)
     */
    private $dateregister = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLastLogon", type="datetime", nullable=true)
     */
    private $datelastlogon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="maritalStatus", type="string", length=255, nullable=true)
     */
    private $maritalstatus;

    /**
     * @var string
     *
     * @ORM\Column(name="birthPlace", type="string", length=255, nullable=true)
     */
    private $birthplace;

    /**
     * @var string
     *
     * @ORM\Column(name="addressStreet", type="string", length=255, nullable=true)
     */
    private $addressstreet;

    /**
     * @var string
     *
     * @ORM\Column(name="addressPost", type="string", length=255, nullable=true)
     */
    private $addresspost;

    /**
     * @var integer
     *
     * @ORM\Column(name="appRoleId", type="integer", nullable=false)
     */
    private $approleid = '2';

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="authToken", type="string", length=64, nullable=true)
     */
    private $authtoken;

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set maritalstatus
     *
     * @param string $maritalstatus
     *
     * @return User
     */
    public function setMaritalstatus($maritalstatus)
    {
        $this->maritalstatus = $maritalstatus;

        return $this;
    }

    /**
     * Get maritalstatus
     *
     * @return string
     */
    public function getMaritalstatus()
    {
        return $this->maritalstatus;
    }

    /**
     * Set birthplace
     *
     * @param string $birthplace
     *
     * @return User
     */
    public function setBirthplace($birthplace)
    {
        $this->birthplace = $birthplace;

        return $this;
    }

    /**
     * Get birthplace
     *
     * @return string
     */
    public function getBirthplace()
    {
        return $this->birthplace;
    }

    /**
     * Set addressstreet
     *
     * @param string $addressstreet
     *
     * @return User
     */
    public function setAddressstreet($addressstreet)
    {
        $this->addressstreet = $addressstreet;

        return $this;
    }

    /**
     * Get addressstreet
     *
     * @return string
     */
    public function getAddressstreet()
    {
        return $this->addressstreet;
    }

    /**
     * Set addresspost
     *
     * @param string $addresspost
     *
     * @return User
     */
    public function setAddresspost($addresspost)
    {
        $this->addresspost = $addresspost;

        return $this;
    }

    /**
     * Get addresspost
     *
     * @return string
     */
    public function getAddresspost()
    {
        return $this->addresspost;
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
     * Set authtoken
     *
     * @param string $authtoken
     *
     * @return User
     */
    public function setAuthtoken($authtoken)
    {
        $this->authtoken = $authtoken;

        return $this;
    }

    /**
     * Get authtoken
     *
     * @return string
     */
    public function getAuthtoken()
    {
        return $this->authtoken;
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
