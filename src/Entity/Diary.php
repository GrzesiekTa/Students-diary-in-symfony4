<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiaryRepository")
 */
class Diary {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Student")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $student;

	/**
	 * @ORM\Column(type="date")
	 * @Assert\Date()
	 */
	private $date;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Status")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $status;

	public function getId() {
		return $this->id;
	}

	public function getStudent():  ? Student {
		return $this->student;
	}

	public function setStudent( ? Student $student) : self{
		$this->student = $student;

		return $this;
	}

	public function getDate() :  ? \DateTimeInterface {
		return $this->date;
	}

	public function setDate(\DateTimeInterface $date) : self{
		$this->date = $date;
		return $this;
	}

	public function getStatus():  ? Status {
		return $this->status;
	}

	public function setStatus( ? Status $status) : self{
		$this->status = $status;
		return $this;
	}
}
