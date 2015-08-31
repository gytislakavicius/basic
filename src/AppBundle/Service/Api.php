<?php

namespace AppBundle\Service;

use AppBundle\Entity\Question;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
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
     * @return array
     */
    public function getQuestions()
    {
        $result = [];

        /** @var Question[] $questions */
        $questions = $this->em->getRepository('AppBundle:Question')->findAll();

        foreach ($questions as $question) {
            $result[] = [
                'id'         => $question->getId(),
                'heading'    => $question->getText(),
                'caption'    => $question->getDescription(),
                'type'       => $question->getType(),
                'isActive'   => $question->isActive(),
                'activeFrom' => $this->formatDate($question->getActiveFrom()),
                'activeTo'   => $this->formatDate($question->getActiveTo()),
                'timeLeft'   => $this->formatDateInterval($question->getTimeLeft()),
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
     * @param \DateTime $dateTime
     *
     * @return array
     */
    public function formatDate(\DateTime $dateTime)
    {
        return [
            'hour'        => $dateTime->format('H'),
            'minute'      => $dateTime->format('i'),
            'second'      => $dateTime->format('s'),
            'millisecond' => 0,
        ];
    }
    /**
     * @param \DateInterval $dateInterval
     *
     * @return array
     */
    public function formatDateInterval(\DateInterval $dateInterval)
    {
        return [
            'hour'        => $dateInterval->format('%h'),
            'minute'      => $dateInterval->format('%i'),
            'second'      => $dateInterval->format('%s'),
            'millisecond' => 0,
        ];
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
     * @return array
     */
    public function setAnswer(User $user, $questionId, $answer)
    {
        $return = 'success';

        try {
            $userAnswer = $this->em->getRepository('AppBundle:UserAnswer')->findOneBy(
                ['user' => $user->getId(), 'question' => $questionId]
            );

            if (empty($userAnswer)) {
                $userAnswer = new UserAnswer();
                $userAnswer->setUser($user);
                $userAnswer->setQuestion($this->em->getRepository('AppBundle:Question')->find($questionId));
            }

            $userAnswer->setAnswer($answer);

            $this->em->persist($userAnswer);
            $this->em->flush();
        } catch (\Exception $e) {
            $return = 'error';
        }

        return $return;
    }
}
