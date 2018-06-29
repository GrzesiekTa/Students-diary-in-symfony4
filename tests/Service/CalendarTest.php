<?php

namespace App\Tests\Service;

use App\Service\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testDaysInMonth()
    {
        $Calendar = new Calendar();
        $result = $Calendar->daysInMonth(6, 2018);

        $this->assertEquals(30, $result);
    }

    public function testShowDay()
    {
        $calendar = new Calendar();
        $calendar->daysInMonth(6, 2018);

        $result = $calendar->showDay(10);

        $this->assertEquals($result, 'Sun');
    }

    public function testNavData()
    {

        $calendar = new Calendar();
        $calendar->daysInMonth(12, 2018);

        $result = $calendar->navData();

        $testData = (object)[
            'nextMonthNumber' => 1,
            'nextYearNumber' => 2019,
            'preMonthNumber' => 11,
            'preYearNumber' => 2018,
        ];

        $this->assertEquals($result, $testData);

    }

    public function testGetYear()
    {
        $calendar = new Calendar();
        $calendar->daysInMonth(6, 2018);

        $result = $calendar->getYear();

        $this->assertEquals($result, 2018);
    }

    public function testGetMonth()
    {
        $calendar = new Calendar();
        $calendar->daysInMonth(6, 2018);

        $result = $calendar->getMonth();

        $this->assertEquals($result, 6);
    }

}