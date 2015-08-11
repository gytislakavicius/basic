<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Answer
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
     * @var integer
     *
     * @ORM\Column(name="questionID", type="integer")
     */
    private $questionID;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="icorrect", type="boolean")
     */
    private $icorrect;


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
     * Set questionID
     *
     * @param integer $questionID
     * @return Answer
     */
    public function setQuestionID($questionID)
    {
        $this->questionID = $questionID;

        return $this;
    }

    /**
     * Get questionID
     *
     * @return integer 
     */
    public function getQuestionID()
    {
        return $this->questionID;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Answer
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
     * Set icorrect
     *
     * @param boolean $icorrect
     * @return Answer
     */
    public function setIcorrect($icorrect)
    {
        $this->icorrect = $icorrect;

        return $this;
    }

    /**
     * Get icorrect
     *
     * @return boolean 
     */
    public function getIcorrect()
    {
        return $this->icorrect;
    }
}
