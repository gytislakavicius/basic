<?php

namespace AppBundle\Tests\Unit\Generator;

use AppBundle\Entity\User;
use AppBundle\Teams\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function getTestGeneratorData()
    {
        $out = [];

        $users = [
            (new User())->setId(1),
            (new User())->setId(2),
            (new User())->setId(3),
            (new User())->setId(4),
            (new User())->setId(5),
            (new User())->setId(6),
            (new User())->setId(7),
            (new User())->setId(8)
        ];

        // #0 case
        $out[] = [
            [2, 2, 2, 2],
            $users,
            2
        ];

        // #1 case
        $out[] = [
            [3, 3, 2],
            $users,
            3
        ];

        // #2 case
        $out[] = [
            [4, 4],
            $users,
            4
        ];

        // #3 case
        $out[] = [
            [4, 4],
            $users,
            5
        ];

        // #4 case
        $out[] = [
            [4, 4],
            $users,
            6
        ];

        // #5 case
        $out[] = [
            [4, 4],
            $users,
            7
        ];

        // #6 case
        $out[] = [
            [8],
            $users,
            8
        ];

        return $out;
    }

    /**
     * @param $expected
     * @param $users
     * @param $numberOfPersons
     *
     * @dataProvider getTestGeneratorData()
     */
    public function testGenerator($expected, $users, $numberOfPersons)
    {
        /** @var Generator $generator */
        $generator = $this->getMockBuilder(Generator::class)->disableOriginalConstructor()->setMethods(null)->getMock();
        $generator->setTeamSize($numberOfPersons);

        $actualCounts = [];
        foreach ($generator->getTeamsAsArray($users) as $team) {
            $actualCounts[] = count($team);
        }

        $this->assertEquals($expected, $actualCounts);
    }
}
