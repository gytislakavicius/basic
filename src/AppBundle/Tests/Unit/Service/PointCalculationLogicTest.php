<?php
/**
 * Created by PhpStorm.
 * User: zivile
 * Date: 8/31/15
 * Time: 9:17 PM
 */

namespace AppBundle\Tests\Unit\Service;


use AppBundle\Entity\Question;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAnswer;
use AppBundle\Service\PointCalculationLogic;

class PointCalculationLogicTest extends \PHPUnit_Framework_TestCase
{
    public function testPcl()
    {
        $user = new User();
        $userAnswers = $this->getUserAnswers();
        /** @var PointCalculationLogic | \PHPUnit_Framework_MockObject_MockObject $pcl */
        $pcl = $this->getMockBuilder(PointCalculationLogic::class)->disableOriginalConstructor()->setMethods(['getUserAnswers'])->getMock();
        $pcl->method('getUserAnswers')->willReturn($userAnswers);

        $pcl->calculateUserPoints($user);

        $this->assertEquals(2.5, $user->getScore());
    }

    private function getUserAnswers()
    {
        $question1 = new Question();
        $question1->setDifficulty(1);

        $question2 = new Question();
        $question2->setDifficulty(2);

        $question3 = new Question();
        $question3->setDifficulty(1.5);

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
}