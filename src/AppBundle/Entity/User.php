<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $intranetId;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $photoUrl;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $team;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $passwordChanged;

    /**
     * @var double
     *
     * @ORM\Column(name="score", type="float", nullable=true)
     */
    private $score;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $winner;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIntranetId()
    {
        return $this->intranetId;
    }

    /**
     * @param mixed $intranetId
     *
     * @return User
     */
    public function setIntranetId($intranetId)
    {
        $this->intranetId = $intranetId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param mixed $photoUrl
     */
    public function setPhotoUrl($photoUrl)
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return boolean
     */
    public function isPasswordChanged()
    {
        return $this->passwordChanged;
    }

    /**
     * @param boolean $passwordChanged
     */
    public function setPasswordChanged($passwordChanged)
    {
        $this->passwordChanged = $passwordChanged;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        if ($this->score === null) {
            return 0;
        }

        return $this->score;
    }

    /**
     * @return boolean
     */
    public function isWinner()
    {
        return $this->winner;
    }

    /**
     * @param boolean $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    /**
     * @param float $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    public function __construct()
    {
        parent::__construct();
        $this->plainPassword = uniqid();
        $this->setPasswordChanged(false);

    }

    public function setPlainPassword($password)
    {
        $this->setPasswordChanged(true);
        parent::setPlainPassword($password);
    }
}
