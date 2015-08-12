<?php

namespace AppBundle\Teams;

use AppBundle\Entity\Team;
use Symfony\Component\Yaml\Parser;

class TeamNameGenerator
{
    private $names;

    private function getNames()
    {
        if (!isset($this->names)) {
            $yaml = new Parser();
            $teamNames = $yaml->parse(file_get_contents('../Resources/teamNames.yml'));
            $this->names = $teamNames;
        }

        return $this->names;
    }

    public function addTeamName(Team $team)
    {
        $randomName = array_rand($this->getNames(), 1);
        $team->setName($randomName);

        //remove the used name
        if (($key = array_search('$randomName', $this->getNames())) !== false) {
            unset($this->getNames()[$key]);
        }
    }
}