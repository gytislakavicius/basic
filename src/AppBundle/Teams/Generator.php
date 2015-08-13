<?php

namespace AppBundle\Teams;

use Doctrine\ORM\EntityManager;

class Generator
{
    /** @var int */
    private $teamSize = 1;

    /** @var TeamNameGenerator */
    private $teamNameGenerator;

    /**
     * @param int $teamSize
     */
    public function setTeamSize($teamSize)
    {
        $this->teamSize = $teamSize;
    }

    /**
     * @param TeamNameGenerator $teamNameGenerator
     */
    public function setTeamNameGenerator($teamNameGenerator)
    {
        $this->teamNameGenerator = $teamNameGenerator;
    }

    /**
     * @param $users
     * @return array
     */
    public function generate($users)
    {
        $chunkedUsers = $this->getChunkedUsers($users);

        foreach ($chunkedUsers as $teamUsers) {
            // TODO: Create team and add it to users
        }

        return $chunkedUsers;
    }

    /**
     * @param array $users
     * @return array|bool
     */
    private function getChunkedUsers($users)
    {
        array_rand($users);
        $dataCount = count($users);
        if ($dataCount == 0) {
            return false;
        }
        $segmentLimit = ceil($dataCount / $this->teamSize);

        return array_chunk($users, $segmentLimit);
    }
}
