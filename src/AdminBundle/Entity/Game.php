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
     * @ORM\Column(name="pathToImg", type="string", length=255, nullable=true)
     */
    private $pathToImg;

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

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Invite", mappedBy="gamesPlayedGuest")
     */
    private $guestsPlaying;

    /**
     * @return mixed
     */
    public function getPathToImg()
    {
        return $this->pathToImg;
    }

    /**
     * @param mixed $pathToImg
     */
    public function setPathToImg($pathToImg)
    {
        $this->pathToImg = $pathToImg;
    }

    /**
     * @return mixed
     */
    public function getGuestsPlaying()
    {
        return $this->guestsPlaying;
    }

    /**
     * @param mixed $guestsPlaying
     */
    public function setGuestsPlaying($guestsPlaying)
    {
        $this->guestsPlaying->add($guestsPlaying);
    }

    public function __construct()
    {
        $this->usersPlaying = new ArrayCollection();
        $this->guestsPlaying = new ArrayCollection();
    }

    public function removeUsersPlaying($user)
    {
        $this->usersPlaying->removeElement($user);
    }

    public function removeGuestsPlaying($user)
    {
        $this->guestsPlaying->removeElement($user);
    }
    /**
     * @return boolean
     */
    public function isPlayedBy($user)
    {
        return $this->usersPlaying->contains($user);
    }

    /**
     * @param $guest
     * @return bool
     */
    public function isPlayedGuest($guest)
    {
        return $this->guestsPlaying->contains($guest);
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