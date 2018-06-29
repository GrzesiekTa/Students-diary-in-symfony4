<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StatusFixttures extends Fixture implements OrderedFixtureInterface {
	public function load(ObjectManager $manager) {

		$this->loadStatutes($manager);

		$manager->flush();
	}

	//======================================
	public function loadStatutes(ObjectManager $manager) {
		$statuses = [
			['puste', 'p'],
			['obecny', 'O'],
			['nieobecny', 'N'],
			['spóżnienie', 'S'],
		];

		foreach ($statuses as [$name, $short_name]) {
			$status = new Status();
			$status->setName($name);
			$status->setShortName($short_name);

			$manager->persist($status);

			$this->addReference($short_name, $status);

		}

		$manager->flush();
	}

	/**
	 * Get the order of this fixture
	 *
	 * @return integer
	 */
	function getOrder() {
		return 1;
	}

}
