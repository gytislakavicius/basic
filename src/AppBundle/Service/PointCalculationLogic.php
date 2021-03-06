<?php

namespace AppBundle\Service;

use AppBundle\Entity\Question;
use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
use Doctrine\ORM\EntityManager;

class PointCalculationLogic
{
    const BONUS_MULTIPLIER = 1.1;
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
    protected function getUserAnswers($user)
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
            /** @var UserAnswer $teamAnswerForQuestion */
            foreach ($teamAnswersForQuestion as $teamAnswerForQuestion) {
                if ($teamAnswerForQuestion->isCorrect()) {
                    $correct++;
                }
                $total++;
            }

            $points += $this->calculateQuestionPoints($correct, $total, $question->getDifficulty());
        }

        $team->setScore(round($points, 3));
    }

    /**
     * @param $team
     * @param $questionId
     * @return array
     */
    protected function getTeamAnswers($team, $questionId)
    {
        return $this->em->getRepository('AppBundle:UserAnswer')->findBy(['team' => $team->getId(), 'question' => $questionId]);
    }

    protected function getQuestions()
    {
        return $this->em->getRepository('AppBundle:Question')->findAll();
    }

    /**
     * @param $correct
     * @param $total
     * @param $difficulty
     *
     * @return float|int
     */
    private function calculateQuestionPoints($correct, $total, $difficulty)
    {
        if ($total == 0) {
            return 0;
        }

        $score = $difficulty * $correct / $total;

        if ($total === $correct) {
            $score = $score * PointCalculationLogic::BONUS_MULTIPLIER;
        }

        return $score;
    }

    public function setWinners()
    {
        $this->setWinner('AppBundle:Team');
        $this->setWinner('AppBundle:User');
    }

    private function setWinner($entityName)
    {
        $highestScore = $this->em->createQueryBuilder()
            ->select('MAX(e.score)')
            ->from($entityName, 'e')
            ->getQuery()
            ->getSingleScalarResult();

        $winning = $this->em->getRepository($entityName)->findBy(['score' => $highestScore]);

        if (empty($winning)) {
            return;
        }

        /** @var User|Team $winner */
        if (count($winning) === 1) {
            $winner = reset($winning);
        } else {
            foreach ($winning as $winner) {
                if ($winner->isWinner()) {
                    // Winner is already set, lets not f**k this up for someone.
                    return;
                }
            }
            $winner = $winning[array_rand($winning)];
        }

        $winner->setWinner(true);

        $this->em->persist($winner);
        $this->em->flush();
    }
}
