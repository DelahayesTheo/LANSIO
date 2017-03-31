<?php

namespace AnonymousBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AnonymousBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlayers", type="integer")
     */
    private $nbPlayers;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPlayersMax", type="integer")
     */
    private $nbPlayersMax;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Game")
     */
    private $game;

    /**
     * @var object
     *
     * @ORM\Column(name="closed", type="boolean")
     */
    private $closed;

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getNbPlayersMax()
    {
        return $this->nbPlayersMax;
    }

    /**
     * @param mixed $nbPlayersMax
     */
    public function setNbPlayersMax($nbPlayersMax)
    {
        $this->nbPlayersMax = $nbPlayersMax;
    }

    /**
     * @return mixed
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * @param mixed $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * @return int
     */
    public function getNbPlayers()
    {
        return $this->nbPlayers;
    }

    /**
     * @param int $nbPlayers
     */
    public function setNbPlayers($nbPlayers)
    {
        $this->nbPlayers = $nbPlayers;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * @return boolean
     */
    public function concernGame()
    {
        return !is_null($this->game);
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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Event
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}

