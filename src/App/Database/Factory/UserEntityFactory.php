<?php

declare(strict_types=1);

namespace App\Database\Factory;

use App\Entity\UserEntity;
use Faker\Generator;

class UserEntityFactory
{
    /**
     * Gera um usuário com dados falsos
     *
     * @param Generator $faker
     * @return array | UserEntity
     * @throws \Exception
     */
    public function __invoke(Generator $faker, string $tipo)
    {
        $firstname = $faker->firstname;
        $lastname  = $faker->lastname;

        $user = (new UserEntity)
            ->setName($firstname . ' ' . $lastname)
            ->setEmail($firstname . '.' . $lastname . '@teste.com')
            ->setPassword(md5($faker->word))
            ->setCreatedAt((new \DateTime)->format('Y-m-d H:i:s'));

        if ($tipo === 'objeto') {
            return $user;
        }

        return $user->getArrayCopy();
    }
}
