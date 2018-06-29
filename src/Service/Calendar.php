<?php
namespace App\Service;

class Calendar {

	private $month;
	private $year;

	public function __construct() {

	}

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

	public function showDay($cellNumber): string{

		$date = "$cellNumber-$this->month-$this->year";
		$nameOfDay = date('D', strtotime($date));
		return $nameOfDay;
	}

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

	public function getMonth(): int {
		return $this->month;
	}
	public function getYear(): int {
		return $this->year;
	}

}