<?php

namespace App\Service;

class Calendar {

    /**
     * @var int 
     */
    private $month;

    /**
     * @var int 
     */
    private $year;

    public function __construct() {
        
    }

    /**
     * number days in month
     * 
     * @param int $month
     * @param int $year
     * 
     * @return int
     */
    public function daysInMonth(int $month = null, int $year = null): int {

        if (null == ($year)) {
            $year = date("Y", time());
        }

        if (null == ($month)) {
            $month = date("m", time());
        }

        $this->month = $month;
        $this->year = $year;

        return date('t', strtotime($year . '-' . $month . '-01'));
    }

    /**
     * show day
     * 
     * @param type $cellNumber
     * 
     * @return string
     */
    public function showDay($cellNumber): string {
        $date = "$cellNumber-$this->month-$this->year";
        $nameOfDay = date('D', strtotime($date));

        return $nameOfDay;
    }

    /**
     * @return type
     */
    public function navData() {

        $nextMonthNumber = $this->month == 12 ? 1 : intval($this->month) + 1;
        $nextYearNumber = $this->month == 12 ? intval($this->year) + 1 : $this->year;

        $preMonthNumber = $this->month == 1 ? 12 : intval($this->month) - 1;
        $preYearNumber = $this->month == 1 ? intval($this->year) - 1 : $this->year;

        return (object) [
                    'nextMonthNumber' => $nextMonthNumber,
                    'nextYearNumber' => $nextYearNumber,
                    'preMonthNumber' => $preMonthNumber,
                    'preYearNumber' => $preYearNumber,
        ];
    }

    /**
     * get month
     * 
     * @return int
     */
    public function getMonth(): int {
        return $this->month;
    }

    /**
     * get year
     * 
     * @return int
     */
    public function getYear(): int {
        return $this->year;
    }

}
