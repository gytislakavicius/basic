<?php

namespace AppBundle\Service;

use AppBundle\Entity\Team;
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

    public function calculateAllPoints()
    {
        $allUsers = $this->em->getRepository('AppBundle:User')->findAll();
        $allTeams = $this->em->getRepository('AppBundle:Team')->findAll();

        foreach ($allUsers as $singleUser) {
            $this->calculateUserPoints($singleUser);
            $this->em->persist($singleUser);
        }

//        foreach ($allTeams as $singleTeam) {
//            $this->calculateTeamPoints($singleTeam);
//            $this->em->persist($singleTeam);
//        }

        $this->em->flush();
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
    private function getUserAnswers($user)
    {
        return $this->em->getRepository('AppBundle:UserAnswer')->findBy(['user' => $user->getId()]);
    }

    /**
     * @param Team $team
     */
    public function calculateTeamPoints($team)
    {
        $points = 0;

        $teamAnswers = $this->getTeamAnswers($team);

    }

    /**
     * @param Team $team
     * @return array
     */
    private function getTeamAnswers($team)
    {
        return $this->em->getRepository('AppBundle:UserAnswer')->findBy(['team' => $team->getId()]);
    }
}