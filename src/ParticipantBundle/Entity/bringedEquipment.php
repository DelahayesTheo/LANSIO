<?php

namespace ParticipantBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * bringedEquipment
 *
 * @ORM\Table(name="bringed_equipment")
 * @ORM\Entity(repositoryClass="ParticipantBundle\Repository\bringedEquipmentRepository")
 */
class bringedEquipment
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Equipment", inversedBy="bringed",cascade={"persist"})
     */
    private $equipment;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="bringedEquipment",cascade={"persist"})
     */
    private $user;

    /**
     * @return mixed
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment)
    {
        $equipment->setBringed($this);
        $this->equipment = $equipment;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $user->setBringedEquipment($this);
        $this->user = $user;
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

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return bringedEquipment
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
