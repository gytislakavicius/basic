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
        $randomName = array_rand($this->names, 1);
        $team->setName($randomName);

        //remove the used name
        if (($key = array_search($randomName, $this->names)) !== false) {
            unset($this->names[$key]);
        }
    }
}
