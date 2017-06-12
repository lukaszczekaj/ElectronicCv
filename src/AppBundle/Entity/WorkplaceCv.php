<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkplaceCv
 *
 * @ORM\Table(name="workplace_cv", indexes={@ORM\Index(name="fk_workplace_cv_workplaceid_idx", columns={"workplace_id"}), @ORM\Index(name="fk_workplace_cv_cvid_idx", columns={"cv_id"})})
 * @ORM\Entity
 */
class WorkplaceCv
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idworkplace_cv", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idworkplaceCv;

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
     * @var \AppBundle\Entity\Workplace
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Workplace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workplace_id", referencedColumnName="id")
     * })
     */
    private $workplace;



    /**
     * Get idworkplaceCv
     *
     * @return integer
     */
    public function getIdworkplaceCv()
    {
        return $this->idworkplaceCv;
    }

    /**
     * Set cv
     *
     * @param \AppBundle\Entity\Cv $cv
     *
     * @return WorkplaceCv
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
     * Set workplace
     *
     * @param \AppBundle\Entity\Workplace $workplace
     *
     * @return WorkplaceCv
     */
    public function setWorkplace(\AppBundle\Entity\Workplace $workplace = null)
    {
        $this->workplace = $workplace;

        return $this;
    }

    /**
     * Get workplace
     *
     * @return \AppBundle\Entity\Workplace
     */
    public function getWorkplace()
    {
        return $this->workplace;
    }
}
