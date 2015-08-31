<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAnswer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserAnswer
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"delete"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * @ORM\Id
     */
    private $user;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question", cascade={"delete"})
     * @ORM\JoinColumn(name="question", referencedColumnName="id")
     * @ORM\Id
     */
    private $question;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", cascade={"delete"})
     * @ORM\JoinColumn(name="team", referencedColumnName="id")
     */
    private $team;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=255)
     */
    private $answer;

    /**
     * @var bool
     *
     * @ORM\Column(name="correct", type="boolean")
     */
    private $correct;

    /**
     * @var \DateTime $answered
     *
     * @ORM\Column(name="answered", type="date")
     */
    private $answered;

    /**
     * @return User
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
        $this->user = $user;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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
    public function isCorrect()
    {
        return $this->correct;
    }

    /**
     * @param boolean $correct
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }

    /**
     * @return \DateTime
     */
    public function getAnswered()
    {
        return $this->answered;
    }

    /**
     * @param \DateTime $answered
     */
    public function setAnswered($answered)
    {
        $this->answered = $answered;
    }
}
