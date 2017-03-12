<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\EquipmentRepository")
 */
class Equipment
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
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Platform")
     */
    private $platform;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\EquipmentType")
     */
    private $equipmentType;

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getEquipmentType()
    {
        return $this->equipmentType;
    }

    /**
     * @param mixed $equipmentType
     */
    public function setEquipmentType($equipmentType)
    {
        $this->equipmentType = $equipmentType;
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
