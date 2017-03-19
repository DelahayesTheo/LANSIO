<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Invite
 *
 * @ORM\Table(name="invite")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\InviteRepository")
 */
class Invite
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
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(name="isComing", type="boolean", nullable=true, options={"default"=false})
     */
    protected $isComing;

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
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\Game", inversedBy="guestsPlaying")
     */
    protected $gamesPlayedGuest;

    public function __construct()
    {
        $this->gamesPlayedGuest = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getGamesPlayed()
    {
        return $this->gamesPlayedGuest;
    }

    /**
     * @param mixed $gamesPlayed
     */
    public function setGamesPlayed($game)
    {
        $game->setGuestsPlaying($this);
        $this->gamesPlayedGuest->add($game);
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
    public function getBringedEquipment()
    {
        return $this->bringedEquipment;
    }

    /**
     * @param mixed $bringedEquipment
     */
    public function setBringedEquipment($bringedEquipment)
    {
        $this->bringedEquipment[] = $bringedEquipment;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fistName
     *
     * @param string $fistName
     *
     * @return Invite
     */
    public function setFirstName($fistName)
    {
        $this->firstName = $fistName;

        return $this;
    }

    /**
     * Get fistName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Invite
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}

