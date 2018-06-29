<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements OrderedFixtureInterface {
	public function load(ObjectManager $manager) {

		$this->loadStudents($manager);

		$manager->flush();
	}

	//========================================================
	public function loadStudents(ObjectManager $manager) {

	    $firstname=['Adam','Michał','Piotrek','Kasia','Asia','Paweł', 'Przemek','Klaudia','Joasia','Klaudiusz','Maurycy','Artur','Daniel','Monika'];
	    $lastanme=['Nowak','Kowalski','Trepka','Duda','Duliba','Adamowicz', 'Pawlak','Danek'];



		for ($i = 0; $i < 20; $i++) {
			$number = $i + 1;
			$student = new Student();
			$student->setFirstname($firstname[array_rand($firstname)]);
			$student->setLastname($lastanme[array_rand($lastanme)]);
			$manager->persist($student);
		}

	}

	/**
	 * Get the order of this fixture
	 *
	 * @return integer
	 */
	function getOrder() {
		return 2;
	}
}
