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
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="isComing", type="boolean", nullable=true, options={"default"=false})
     */
    protected $isComing;

    /**
     * @ORM\Column(name="cohort", type="string", length=255, nullable=true)
     */
    private $cohort;
    /**
     * @ORM\Column(name="isEating", type="boolean", nullable=true)
     */
    protected $isEating;

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
     * @ORM\OneToMany(targetEntity="ParticipantBundle\Entity\bringedEquipment", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $bringedEquipment;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\SupportRequest", mappedBy="user")
     */
    protected $supportRequests;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Invite", cascade={"remove"})
     */
    protected $invite;

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
    public function getCohort()
    {
        return $this->cohort;
    }

    /**
     * @param mixed $cohort
     */
    public function setCohort($cohort)
    {
        $this->cohort = $cohort;
    }

    /**
     * @return mixed
     */
    public function getSupportRequests()
    {
        return $this->supportRequests;
    }

    /**
     * @param mixed $supportRequests
     */
    public function setSupportRequests($supportRequests)
    {
        $this->supportRequests[] = $supportRequests;
    }

    /**
     * @return mixed
     */
    public function getBringedEquipment()
    {
        return $this->bringedEquipment;
    }

    /**
     * @param mixed $bringedEquipment
     */
    public function setBringedEquipment($bringedEquipment)
    {
        $this->bringedEquipment->add($bringedEquipment);
    }

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
    public function getInvite()
    {
        return $this->invite;
    }

    /**
     * @param mixed $invite
     */
    public function setInvite($invite)
    {
        $this->invite = $invite;
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
    public function hasGuest()
    {
        return !is_null($this->invite);
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
        $this->bringedEquipment = new ArrayCollection();
        $this->gamesPlayed = new ArrayCollection();
        parent::__construct();
        // your own logic
    }
}
