<?php

namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;

/**
 * Class Api
 **/
class Api
{
    /** @var EntityManager  */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function isGameInProgress()
    {
        return  $this->getSetting('game_in_progress');
    }

    public function isGameDone()
    {
        return  $this->getSetting('game_done');
    }

    public function getQuestions()
    {
        return [];
    }

    protected function getSetting($name)
    {
        return $this->em->getRepository('AppBundle:Settings')->findOneBy(['name' => $name])->getValue();
    }
}
