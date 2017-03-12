<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use UserBundle\Repository\UserRepository;
/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="isComing", type="boolean", nullable=true, options={"default"=false})
     */
    protected $isComing;

    /**
     * @ORM\Column(name="isEating", type="boolean", nullable=true)
     */
    protected $isEating;

    /**
     * @ORM\Column(name="hasGuest", type="boolean", nullable=true)
     */
    protected $hasGuest;

    /**
     * @ORM\Column(name="needScreen", type="boolean", nullable=true)
     */
    protected $needScreen;

    /**
     * @ORM\Column(name="needKeyboard", type="boolean", nullable=true)
     */
    protected $needKeyboard;

    /**
     * @ORM\Column(name="needNetworkCable", type="boolean", nullable=true)
     */
    protected $needNetworkCable;

    /**
     * @ORM\Column(name="needMouse", type="boolean", nullable=true)
     */
    protected $needMouse;

    /**
     * @return mixed
     */
    public function getNeedNetworkCable()
    {
        return $this->needNetworkCable;
    }

    /**
     * @param mixed $needNetworkCable
     */
    public function setNeedNetworkCable($needNetworkCable)
    {
        $this->needNetworkCable = $needNetworkCable;
    }

    /**
     * @return mixed
     */
    public function getNeedMouse()
    {
        return $this->needMouse;
    }

    /**
     * @param mixed $needMouse
     */
    public function setNeedMouse($needMouse)
    {
        $this->needMouse = $needMouse;
    }


    /**
     * @ORM\Column(name="hasDefinedRequired", type="boolean", nullable=true)
     */
    protected $hasDefinedRequired;

    /**
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Game", inversedBy="usersPlaying")
     */
    protected $gamesPlayed;

    /**
     * @return mixed
     */
    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
    }

    /**
     * @param mixed $gametoRemove
     */
    public function removeGamePlayed($game)
    {
        $this->gamesPlayed->removeElement($game);
    }

    /**
     * @param mixed $gamesPlayed
     */
    public function setGamesPlayed($gamesPlayed)
    {
        $this->gamesPlayed->add($gamesPlayed);
    }

    /**
     * @return mixed
     */
    public function getIsComing()
    {
        return $this->isComing;
    }

    /**
     * @param mixed $isComing
     */
    public function setIsComing($isComing)
    {
        $this->isComing = $isComing;
    }

    /**
     * @return mixed
     */
    public function getIsEating()
    {
        return $this->isEating;
    }

    /**
     * @param mixed $isEating
     */
    public function setIsEating($isEating)
    {
        $this->isEating = $isEating;
    }

    /**
     * @return mixed
     */
    public function getHasGuest()
    {
        return $this->hasGuest;
    }

    /**
     * @param mixed $hasGuest
     */
    public function setHasGuest($hasGuest)
    {
        $this->hasGuest = $hasGuest;
    }

    /**
     * @return mixed
     */
    public function getNeedScreen()
    {
        return $this->needScreen;
    }

    /**
     * @param mixed $needScreen
     */
    public function setNeedScreen($needScreen)
    {
        $this->needScreen = $needScreen;
    }

    /**
     * @return mixed
     */
    public function getNeedKeyboard()
    {
        return $this->needKeyboard;
    }

    /**
     * @param mixed $needKeyboard
     */
    public function setNeedKeyboard($needKeyboard)
    {
        $this->needKeyboard = $needKeyboard;
    }

    /**
     * @return mixed
     */
    public function getHasDefinedRequired()
    {
        return $this->hasDefinedRequired;
    }

    /**
     * @param mixed $hasDefinedRequired
     */
    public function setHasDefinedRequired($hasDefinedRequired)
    {
        $this->hasDefinedRequired = $hasDefinedRequired;
    }


    public function __construct()
    {
        $this->gamesPlayed = new ArrayCollection();
        parent::__construct();
        // your own logic
    }
}
