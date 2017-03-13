<?php

namespace AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\GameRepository")
 * @ORM\Table
 */
class Game
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Platform")
     */
    private $platform;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbMaxPlayer;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $kind;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="gamesPlayed")
     */
    private $usersPlaying;
    public function __construct()
    {
        $this->usersPlaying = new ArrayCollection();
    }

    public function removeUsersPlaying($user)
    {
        $this->usersPlaying->removeElement($user);
    }
    /**
     * @return boolean
     */
    public function isPlayedBy($user)
    {
        return $this->usersPlaying->contains($user);
    }
    /**
     * @return mixed
     */
    public function getUsersPlaying()
    {
        return $this->usersPlaying;
    }

    /**
     * @param mixed $usersPlaying
     */
    public function setUsersPlaying($usersPlaying)
    {
        $this->usersPlaying->add($usersPlaying);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

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
    public function getNbMaxPlayer()
    {
        return $this->nbMaxPlayer;
    }

    /**
     * @param mixed $nbMaxPlayer
     */
    public function setNbMaxPlayer($nbMaxPlayer)
    {
        $this->nbMaxPlayer = $nbMaxPlayer;
    }

    /**
     * @return mixed
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param mixed $kind
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}