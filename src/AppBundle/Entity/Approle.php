<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Approle
 *
 * @ORM\Table(name="appRole")
 * @ORM\Entity
 */
class Approle
{
    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=45, nullable=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="roleName", type="string", length=45, nullable=true)
     */
    private $rolename;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Approle
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set rolename
     *
     * @param string $rolename
     *
     * @return Approle
     */
    public function setRolename($rolename)
    {
        $this->rolename = $rolename;

        return $this;
    }

    /**
     * Get rolename
     *
     * @return string
     */
    public function getRolename()
    {
        return $this->rolename;
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
