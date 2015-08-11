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
     * @ORM\Column(type="integer")
     */
    protected $intranetId;

    /**
     * @ORM\Column(type="string", length="150")
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length="15")
     */
    protected $uniqueUsername;

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
    public function getUniqueUsername()
    {
        return $this->uniqueUsername;
    }

    /**
     * @param mixed $uniqueUsername
     *
     * @return User
     */
    public function setUniqueUsername($uniqueUsername)
    {
        $this->uniqueUsername = $uniqueUsername;

        return $this;
    }
}
