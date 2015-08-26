<?php

namespace AppBundle\Tests\Unit\Service;
use AppBundle\Service\Api;

/**
 * Unit test for API service
 **/
class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * Data provider for testFormatDate()
     * @return array
     */
    public function getTestFormatDateData()
    {
        $cases = [];

        // case 0
        $cases[] = [
            new \DateTime('2015-08-26 21:59:12', new \DateTimeZone('Europe/Vilnius')),
            [
                'hour'        => 21,
                'minute'      => 59,
                'second'      => 12,
                'millisecond' => 0,
            ]
        ];

        // case 1
        $cases[] = [
            new \DateTime('2015-08-26 23:59:59', new \DateTimeZone('Europe/Vilnius')),
            [
                'hour'        => 23,
                'minute'      => 59,
                'second'      => 59,
                'millisecond' => 0,
            ]
        ];

        // case 2
        $cases[] = [
            new \DateTime('2015-08-26 00:00:01', new \DateTimeZone('Europe/Vilnius')),
            [
                'hour'        => 0,
                'minute'      => 0,
                'second'      => 1,
                'millisecond' => 0,
            ]
        ];

        return $cases;
    }

    /**
     * @param $dateTime
     * @param $expectedArray
     *
     * @dataProvider getTestFormatDateData()
     */
    public function testFormatDate($dateTime, $expectedArray)
    {
        $emMock = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $service = new Api($emMock);

        $this->assertEquals(
            $expectedArray,
            $service->formatDate($dateTime)
        );
    }
    /**
     *
     * Data provider for testFormatDate()
     * @return array
     */
    public function getTestFormatDateIntervalData()
    {
        $cases = [];

        // case 0
        $cases[] = [
            new \DateInterval("PT2H3M4S"),
            [
                'hour'        => 2,
                'minute'      => 3,
                'second'      => 4,
                'millisecond' => 0,
            ]
        ];

        // case 1
        $cases[] = [
            new \DateInterval("PT0S"),
            [
                'hour'        => 0,
                'minute'      => 0,
                'second'      => 0,
                'millisecond' => 0,
            ]
        ];

        // case 2
        $cases[] = [
            new \DateInterval("PT15H0S"),
            [
                'hour'        => 15,
                'minute'      => 0,
                'second'      => 0,
                'millisecond' => 0,
            ]
        ];

        return $cases;
    }

    /**
     * @param $dateInterval
     * @param $expectedArray
     *
     * @dataProvider getTestFormatDateIntervalData()
     */
    public function testFormatDateInterval($dateInterval, $expectedArray)
    {
        $emMock = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $service = new Api($emMock);

        $this->assertEquals(
            $expectedArray,
            $service->formatDateInterval($dateInterval)
        );
    }
}
