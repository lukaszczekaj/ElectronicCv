<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv
 *
 * @ORM\Table(name="cv")
 * @ORM\Entity
 */
class Cv
{
    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="interests", type="text", length=65535, nullable=true)
     */
    private $interests;

    /**
     * @var integer
     *
     * @ORM\Column(name="pdf_layout", type="integer", nullable=true)
     */
    private $pdfLayout;

    /**
     * @var string
     *
     * @ORM\Column(name="list_education", type="text", length=65535, nullable=true)
     */
    private $listEducation;

    /**
     * @var string
     *
     * @ORM\Column(name="list_workplace", type="text", length=65535, nullable=true)
     */
    private $listWorkplace;

    /**
     * @var string
     *
     * @ORM\Column(name="list_additional_skills", type="text", length=65535, nullable=true)
     */
    private $listAdditionalSkills;

    /**
     * @var string
     *
     * @ORM\Column(name="list_languages", type="text", length=65535, nullable=true)
     */
    private $listLanguages;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Cv
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Cv
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set interests
     *
     * @param string $interests
     *
     * @return Cv
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Get interests
     *
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set pdfLayout
     *
     * @param integer $pdfLayout
     *
     * @return Cv
     */
    public function setPdfLayout($pdfLayout)
    {
        $this->pdfLayout = $pdfLayout;

        return $this;
    }

    /**
     * Get pdfLayout
     *
     * @return integer
     */
    public function getPdfLayout()
    {
        return $this->pdfLayout;
    }

    /**
     * Set listEducation
     *
     * @param string $listEducation
     *
     * @return Cv
     */
    public function setListEducation($listEducation)
    {
        $this->listEducation = $listEducation;

        return $this;
    }

    /**
     * Get listEducation
     *
     * @return string
     */
    public function getListEducation()
    {
        return $this->listEducation;
    }

    /**
     * Set listWorkplace
     *
     * @param string $listWorkplace
     *
     * @return Cv
     */
    public function setListWorkplace($listWorkplace)
    {
        $this->listWorkplace = $listWorkplace;

        return $this;
    }

    /**
     * Get listWorkplace
     *
     * @return string
     */
    public function getListWorkplace()
    {
        return $this->listWorkplace;
    }

    /**
     * Set listAdditionalSkills
     *
     * @param string $listAdditionalSkills
     *
     * @return Cv
     */
    public function setListAdditionalSkills($listAdditionalSkills)
    {
        $this->listAdditionalSkills = $listAdditionalSkills;

        return $this;
    }

    /**
     * Get listAdditionalSkills
     *
     * @return string
     */
    public function getListAdditionalSkills()
    {
        return $this->listAdditionalSkills;
    }

    /**
     * Set listLanguages
     *
     * @param string $listLanguages
     *
     * @return Cv
     */
    public function setListLanguages($listLanguages)
    {
        $this->listLanguages = $listLanguages;

        return $this;
    }

    /**
     * Get listLanguages
     *
     * @return string
     */
    public function getListLanguages()
    {
        return $this->listLanguages;
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
