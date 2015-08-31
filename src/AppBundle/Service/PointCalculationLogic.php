<?php

namespace AppBundle\Service;

class PointCalculationLogic
{
    const DEFAULT_BONUS = 1.1;
    /**
     * @param $correct
     * @param $total
     * @param $weight
     * @return float
     */
    public function calculateTeamQuestionScore($correct, $total, $weight)
    {
        return $weight * $correct / $total * $this->getBonus($correct, $total);
    }

    public function getBonus($correct, $total)
    {
        //no modifier
        $bonus = 1;

        if ($correct == $total) {
            $bonus = PointCalculationLogic::DEFAULT_BONUS;
        }
         return $bonus;
    }
}
