<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
use Doctrine\ORM\EntityManager;

class PointCalculationLogic
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

    public function calculateUserPoints(User $user)
    {
        $points = 0;

        $userAnswers = $this->getUserAnswers($user);
        /** @var UserAnswer $userAnswer */
        foreach ($userAnswers as $userAnswer) {
            if ($userAnswer->isCorrect()) {
                $points += $userAnswer->getQuestion()->getDifficulty();
            }
        }
        $user->setScore($points);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserAnswers($user)
    {
        return $this->em->getRepository('AppBundle:UserAnswer')->findBy(['user' => $user->getId()]);
    }
}