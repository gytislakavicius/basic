<?php
/**
 * Created by PhpStorm.
 * User: zivile
 * Date: 8/31/15
 * Time: 9:17 PM
 */

namespace AppBundle\Tests\Unit\Service;


use AppBundle\Entity\Question;
use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
use AppBundle\Service\PointCalculationLogic;

class PointCalculationLogicTest extends \PHPUnit_Framework_TestCase
{
    public function testUserPcl()
    {
        $user = new User();
        $userAnswers = $this->getUserAnswers();
        /** @var PointCalculationLogic | \PHPUnit_Framework_MockObject_MockObject $pcl */
        $pcl = $this->getMockBuilder(PointCalculationLogic::class)->disableOriginalConstructor()->setMethods(['getUserAnswers'])->getMock();
        $pcl->method('getUserAnswers')->willReturn($userAnswers);

        $pcl->calculateUserPoints($user);

        $this->assertEquals(2.5, $user->getScore());
    }

    public function getTeamPclData()
    {
        $out = [];

        $teamAnswers = $this->getTeamAnswers(new Team());

        //two right, one wrong
        $out[] = [
            'fixture' => [$teamAnswers[1], [], [], [], []],
            'expected' => 0.667
        ];

        //all wrong
        $out[] = [
            'fixture' => [[], $teamAnswers[2], [], [], []],
            'expected' => 0
        ];

        //all unanswered
        $out[] = [
            'fixture' => [[], [], $teamAnswers[3], [], []],
            'expected' => 0
        ];

        //one right, one wrong, one unanswered
        $out[] = [
            'fixture' => [[], [], [], $teamAnswers[4], []],
            'expected' => 0.75
        ];

        //all scores combined
        $out[] = [
            'fixture' => [$teamAnswers[1], $teamAnswers[2], $teamAnswers[3], $teamAnswers[4], []],
            'expected' => 1.417
        ];

        //all correct plus bonus
        $out[] = [
            'fixture' => [[], [], [], [], $teamAnswers[5]],
            'expected' => 1.65
        ];

        return $out;
    }

    /**
     * @dataProvider getTeamPclData()
     */
    public function testTeamPcl($fixture, $expected)
    {
        $team1 = new Team;
        $questions = $this->getQuestions();

        /** @var PointCalculationLogic | \PHPUnit_Framework_MockObject_MockObject $pcl */
        $pcl = $this->getMockBuilder(PointCalculationLogic::class)->disableOriginalConstructor()->setMethods(
            ['getQuestions', 'getTeamAnswers'])->getMock();
        $pcl->method('getQuestions')->willReturn($questions);

        //one question answered
        $pcl->method('getTeamAnswers')->will(
            $this->onConsecutiveCalls($fixture[0], $fixture[1], $fixture[2], $fixture[3], $fixture[4])
        );
        $pcl->calculateTeamPoints($team1);
        $this->assertEquals($expected, $team1->getScore());
    }

    private function getUserAnswers()
    {
        //questions
        $question1 = new Question();
        $question1->setDifficulty(1);

        $question2 = new Question();
        $question2->setDifficulty(2);

        $question3 = new Question();
        $question3->setDifficulty(1.5);

        //user answers
        $userAnswer1 = new UserAnswer();
        $userAnswer1->setAnswer('atsakymas');
        $userAnswer1->setCorrect(true);
        $userAnswer1->setQuestion($question1);

        $userAnswer2 = new UserAnswer();
        $userAnswer2->setAnswer('atsakymas');
        $userAnswer2->setCorrect(false);
        $userAnswer2->setQuestion($question2);

        $userAnswer3 = new UserAnswer();
        $userAnswer3->setAnswer('atsakymas');
        $userAnswer3->setCorrect(true);
        $userAnswer3->setQuestion($question3);

        $answers = [$userAnswer1, $userAnswer2, $userAnswer3];

        return $answers;
    }

    private function getTeamAnswers($team)
    {
        //questions
        $questions = $this->getQuestions();

        //Team Answers, Question #0, two correct, difficulty 1, score = 1.5
        $answer1 = new UserAnswer();
        $answer1->setTeam($team);
        $answer1->setCorrect(true);
        $answer1->setQuestion($questions[0]);

        $answer2 = clone $answer1;
        $answer2->setCorrect(false);

        $answer3 = clone $answer1;


        //Team Answers, Question #1, all incorrect, score 0
        $answer4 = new UserAnswer();
        $answer4->setTeam($team);
        $answer4->setCorrect(false);
        $answer4->setQuestion($questions[1]);

        $answer5 = clone $answer4;

        $answer6 = clone $answer4;

        //Team Answers, Question #2, all incorrect, score 0
        $answer4 = new UserAnswer();
        $answer4->setTeam($team);
        $answer4->setCorrect(false);
        $answer4->setQuestion($questions[2]);

        $answer5 = clone $answer4;

        $answer6 = clone $answer4;

        //Team Answers, Question #4, one right, one wrong, one unanswered
        $answer7 = new UserAnswer();
        $answer7->setTeam($team);
        $answer7->setCorrect(false);
        $answer7->setQuestion($questions[3]);

        $answer8 = clone $answer4;
        $answer8->setCorrect(true);

        //all correct plus bonus
        $answer9 = new UserAnswer();
        $answer9->setTeam($team);
        $answer9->setCorrect(true);
        $answer9->setQuestion($questions[4]);

        $answer10 = clone $answer9;

        $answer11 = clone $answer9;

        return [
            1 => [$answer1, $answer2, $answer3],
            2 => [$answer4, $answer5, $answer6],
            3 => [],
            4 => [$answer7, $answer8],
            5 => [$answer9, $answer10, $answer11]
        ];
    }

    private function getQuestions()
    {
        $question1 = new Question();
        $question1->setId(1);
        $question1->setDifficulty(1);

        $question2 = new Question();
        $question2->setId(2);
        $question2->setDifficulty(1.1);

        $question3 = new Question();
        $question3->setId(3);
        $question3->setDifficulty(1.5);

        $question4 = new Question();
        $question4->setId(4);
        $question4->setDifficulty(1.5);

        $question5 = new Question();
        $question5->setId(5);
        $question5->setDifficulty(1.5);

        $questions = [$question1, $question2, $question3, $question4, $question5];

        return $questions;
    }
}