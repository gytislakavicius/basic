<?php

namespace AppBundle\Tests\Unit\Generator;

use AppBundle\Entity\User;
use AppBundle\Teams\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function getTestGeneratorData()
    {
        $out = [];

        $user1 = (new User())->setId(123);
        $user2 = (new User())->setId(323);
        $user3 = (new User())->setId(11);
        $user4 = (new User())->setId(12);

        $users = [
            $user1,
            $user2,
            $user3,
            $user4
        ];

        // #0 case
        $out[] = [
            [
                [
                    $user1,
                    $user2
                ],
                [
                    $user3,
                    $user4
                ]
            ],
            $users,
            2
        ];

        // #1 case
        $out[] = [
            [
                [
                    $user1,
                    $user2
                ],
                [
                    $user3,
                    $user4
                ]
            ],
            $users,
            3
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
        $generator = new Generator($users);
        $generator->setNumberOfPersons($numberOfPersons);

        $this->assertEquals($expected, $generator->generate($users));
    }
}
