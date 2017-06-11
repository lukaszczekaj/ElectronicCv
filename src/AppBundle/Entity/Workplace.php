<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Workplace
 *
 * @ORM\Table(name="workplace")
 * @ORM\Entity
 */
class Workplace
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of", type="datetime", nullable=true)
     */
    private $dateOf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_to", type="datetime", nullable=true)
     */
    private $dateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set dateOf
     *
     * @param \DateTime $dateOf
     *
     * @return Workplace
     */
    public function setDateOf($dateOf)
    {
        $this->dateOf = $dateOf;

        return $this;
    }

    /**
     * Get dateOf
     *
     * @return \DateTime
     */
    public function getDateOf()
    {
        return $this->dateOf;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return Workplace
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Workplace
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
