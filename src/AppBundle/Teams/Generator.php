<?php

namespace AppBundle\Teams;

class Generator
{
    /**
     * @var int
     */
    private $numberOfPersons = 1;

    /**
     * @param int $numberOfPersons
     */
    public function setNumberOfPersons($numberOfPersons)
    {
        $this->numberOfPersons = $numberOfPersons;
    }

    /**
     * @param $users
     * @return array
     */
    public function generate($users)
    {
        // TODO: User randomisation
        $dataCount = count($users);
        if ($dataCount == 0) {
            return false;
        }
        $segmentLimit = ceil($dataCount / $this->numberOfPersons);
        $outputArray = array_chunk($users, $segmentLimit);

        return $outputArray;
    }
}
