<?php

namespace AppBundle\Teams;

use AppBundle\Entity\Team;

class TeamNameGenerator
{
    /** @var array */
    private $names;

    /**
     * @param array $names
     */
    public function setNames($names)
    {
        $this->names = $names;
    }

    public function addTeamName(Team $team)
    {
        $randomKey = array_rand($this->names, 1);
        $randomName = $this->names[$randomKey];
        $team->setName($randomName);

        //remove the used name
        unset($this->names[$randomKey]);
    }
}
