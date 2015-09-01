<?php

namespace AppBundle\Service;

use AppBundle\Entity\Question;
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

        foreach ($allTeams as $singleTeam) {
            $this->calculateTeamPoints($singleTeam);
            $this->em->persist($singleTeam);
        }

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

        $questions = $this->getQuestions();
        /** @var Question $question */
        foreach ($questions as $question) {
            $teamAnswersForQuestion = $this->getTeamAnswers($team, $question->getId());

            $total = 0;
            $correct = 0;

            foreach ($teamAnswersForQuestion as $teamAnswerForQuestion) {
                if ($teamAnswerForQuestion->isCorrect()) {
                    $correct++;
                }
                $total++;
            }

            $points += $this->calculateQuestionPoints($correct, $total, $question->getDifficulty());
        }

        $team->setScore($points);
    }

    /**
     * @param $team
     * @param $questionId
     * @return array
     */
    private function getTeamAnswers($team, $questionId)
    {
        return $this->em->getRepository('AppBundle:UserAnswer')->findBy(['team' => $team->getId(), 'question' => $questionId]);
    }

    private function getQuestions()
    {
        return $this->em->getRepository('AppBundle:Question')->findAll();
    }

    private function calculateQuestionPoints($correct, $total, $difficulty)
    {
        return $difficulty * $correct / $total;
    }
}