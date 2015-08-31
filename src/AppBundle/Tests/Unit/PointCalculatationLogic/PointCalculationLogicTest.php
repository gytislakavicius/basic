<?php

namespace AppBundle\Tests\Unit\PointCalculationLogic;

use AppBundle\Service\PointCalculationLogic;

class PointCalculationLogicTest extends \PHPUnit_Framework_TestCase
{

    public function testGetTeamQuestionScore()
    {
        //no bonus
        $pointCalculation = new PointCalculationLogic();
        $this->assertEquals(1.6, $pointCalculation->calculateTeamQuestionScore(4, 5, 2));
    }

}
