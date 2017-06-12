<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EducationCv
 *
 * @ORM\Table(name="education_cv", indexes={@ORM\Index(name="fk_education_cv_educationid_idx", columns={"education_id"}), @ORM\Index(name="fk_education_cv_cvid_idx", columns={"cv_id"})})
 * @ORM\Entity
 */
class EducationCv
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ideducation_cv", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ideducationCv;

    /**
     * @var \AppBundle\Entity\Cv
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cv_id", referencedColumnName="id")
     * })
     */
    private $cv;

    /**
     * @var \AppBundle\Entity\Education
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Education")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="education_id", referencedColumnName="id")
     * })
     */
    private $education;



    /**
     * Get ideducationCv
     *
     * @return integer
     */
    public function getIdeducationCv()
    {
        return $this->ideducationCv;
    }

    /**
     * Set cv
     *
     * @param \AppBundle\Entity\Cv $cv
     *
     * @return EducationCv
     */
    public function setCv(\AppBundle\Entity\Cv $cv = null)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get cv
     *
     * @return \AppBundle\Entity\Cv
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * Set education
     *
     * @param \AppBundle\Entity\Education $education
     *
     * @return EducationCv
     */
    public function setEducation(\AppBundle\Entity\Education $education = null)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return \AppBundle\Entity\Education
     */
    public function getEducation()
    {
        return $this->education;
    }
}
