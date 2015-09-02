<?php

namespace AppBundle\Service;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    /**
     * @return mixed
     */
    public function isGameInProgress()
    {
        return  $this->getSetting('game_in_progress');
    }

    /**
     * @return mixed
     */
    public function isGameDone()
    {
        return  $this->getSetting('game_done');
    }

    /**
     * @param User $currentUser
     *
     * @return array
     */
    public function getQuestions(User $currentUser = null)
    {
        $result = [];

        /** @var Question[] $questions */
        $questions = $this->em->getRepository('AppBundle:Question')->findBy([], ['activeFrom' => 'ASC']);

        foreach ($questions as $question) {
            $entry = [
                'id'         => $question->getId(),
                'type'       => $question->getType(),
                'isActive'   => $question->isActive(),
                'activeFrom' => $question->getActiveFrom()->getTimestamp(),
                'activeTo'   => $question->getActiveTo()->getTimestamp(),
            ];

            if ($question->isPubliclyAvailable()) {
                $entry['text']    = $question->getText();
                $entry['answers'] = $this->getAnswersForQuestion($question);
            } else {
                $entry['text']    = 'Dar nepaskelbtas';
            }

            if ($currentUser !== null) {
                $answer = $this->em->getRepository('AppBundle:UserAnswer')->findOneBy([
                    'question' => $question->getId(),
                    'user'     => $currentUser->getId(),
                ]);

                if ($answer) {
                    $entry['answered'] = true;
                } else {
                    $entry['answered'] = false;
                }
            }

            $result[] = $entry;
        }

        return $result;
    }

    /**
     * @param Question $question
     *
     * @return array
     */
    protected function getAnswersForQuestion(Question $question)
    {
        $result = [];

        $answers = $this->em->getRepository('AppBundle:Answer')->findBy(['question' => $question->getId()]);

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $result[] = [
                'id' => $answer->getId(),
                'text' => $answer->getText(),
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getPersons()
    {
        $result = [];

        /** @var User[] $users */
        $users = $this->em->getRepository('AppBundle:User')->findBy(['enabled' => 1]);

        foreach ($users as $user) {
            $result[] = [
                'id'    => $user->getId(),
                'name'  => $user->getFullName(),
                'image' => $user->getPhotoUrl(),
            ];
        }

        return $result;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    protected function getSetting($name)
    {
        $setting = $this->em->getRepository('AppBundle:Settings')->findOneBy(['name' => $name]);

        return $setting ? $setting->getValue() : null;
    }

    /**
     * @param User      $user
     * @param string    $questionId
     * @param string    $answer
     *
     * @throws EntityNotFoundException
     * @throws AccessDeniedException
     * @throws AlreadySubmittedException
     */
    public function setAnswer($user, $questionId, $answer)
    {
        $question = $this->em->getRepository('AppBundle:Question')->find($questionId);
        $team = $user->getTeam();

        if (empty($question) || empty($user) || empty($team)) {
            throw new EntityNotFoundException;
        }

        $currentTime = new \DateTime();
        if ($question->getActiveFrom() <= $currentTime && $currentTime <= $question->getActiveTo()) {
            $userAnswer = $this->em->getRepository('AppBundle:UserAnswer')->findOneBy(
                ['user' => $user->getId(), 'question' => $questionId]
            );

            if (!empty($userAnswer)) {
                throw new AlreadySubmittedException;
            }

            $userAnswer = new UserAnswer();
            $userAnswer->setUser($user);
            $userAnswer->setQuestion($question);
            $userAnswer->setTeam($user->getTeam());
            $userAnswer->setAnswer($answer);
            $userAnswer->setCorrect($this->isAnswerCorrect($question, $answer));
            $userAnswer->setAnswered(new \DateTime());

            $this->em->persist($userAnswer);
            $this->em->flush();
        } else {
            throw new AccessDeniedException;
        }
    }

    /**
     * @param Question $question
     * @param string   $answer
     * @return bool
     */
    private function isAnswerCorrect(Question $question, $answer)
    {
        $correct = false;

        $correctAnswer = $this->em->getRepository('AppBundle:Answer')->findOneBy(
            ['question' => $question->getId(), 'correct' => true]
        );

        if ($correctAnswer->getId() == $answer || strtolower($correctAnswer->getText()) == strtolower($answer)) {
            $correct = true;
        }

        return $correct;
    }
}
