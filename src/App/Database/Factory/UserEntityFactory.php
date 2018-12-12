<?php

declare(strict_types=1);

namespace App\Database\Factory;

use App\Entity\UserEntity;
use Faker\Generator;

class UserEntityFactory
{
	public function __invoke(Generator $faker)
	{
		$firstname = $faker->firstname;
		$lastname  = $faker->lastname;

		$user = (new UserEntity)
			->setName($firstname . ' ' . $lastname)
			->setEmail($firstname . '.' . $lastname . '@teste.com')
			->setPassword(md5($faker->word))
			->setCreatedAt((new \DateTime)->format('Y-m-d H:i:s'));

		return $user->getArrayCopy();
	}
}