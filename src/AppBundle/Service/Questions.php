<?php

namespace AppBundle\Service;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
use Doctrine\ORM\EntityManager;

class Questions
{
    /** @var  EntityManager */
    protected $em;

    /** @var  Api */
    protected $api;

    /**
     * @param EntityManager $em
     * @param Api           $api
     */
    public function __construct($em, $api)
    {
        $this->em  = $em;
        $this->api = $api;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function getMyQuestions(User $user)
    {
        $result = [];

        /** @var Question[] $questions */
        $questions = $this->api->getQuestions();

        foreach ($questions as $question) {
            $entry = [
                'text'     => $question['text'],
                'answered' => false,
            ];

            /** @var UserAnswer $userAnswer */
            $userAnswer = $this->em->getRepository('AppBundle:UserAnswer')->findOneBy([
                'question' => $question['id'],
                'user'     => $user->getId(),
            ]);

            if ($userAnswer) {
                $entry['answered'] = true;

                /** @var Answer $answerEntity */
                $answerEntity = $this->em->getRepository('AppBundle:Answer')->findOneBy(
                    ['question' => $question['id'], 'id' => $userAnswer->getAnswer()]
                );

                if ($answerEntity) {
                    $entry['answer'] = $answerEntity->getText();
                } else {
                    $entry['answer'] = $userAnswer->getAnswer();
                }
            }

            $result[] = $entry;
        }

        return $result;
    }
}