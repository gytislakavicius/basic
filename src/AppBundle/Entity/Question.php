<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2000)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255)
     */
    private $difficulty;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;

    /**
     * @ORM\Column(name="activeFrom", type="datetime")
     */
    private $activeFrom;

    /**
     * @ORM\Column(name="activeTo", type="datetime")
     */
    private $activeTo;

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
     * Set type
     *
     * @param string $type
     * @return Question
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Question
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set difficulty
     *
     * @param string $difficulty
     * @return Question
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string 
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    public function __toString()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getActiveFrom()
    {
        return $this->activeFrom;
    }

    /**
     * @param mixed $activeFrom
     */
    public function setActiveFrom($activeFrom)
    {
        $this->activeFrom = $activeFrom;
    }

    /**
     * @return mixed
     */
    public function getActiveTo()
    {
        return $this->activeTo;
    }

    /**
     * @param mixed $activeTo
     */
    public function setActiveTo($activeTo)
    {
        $this->activeTo = $activeTo;
    }

    public function isActive()
    {
        $now = new \DateTime();

        return $now >= $this->getactiveFrom() && $now <= $this->getActiveTo();
    }
}
