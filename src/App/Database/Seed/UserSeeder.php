<?php

declare(strict_types=1);

use App\Database\Factory\UserEntityFactory;
use Faker\Factory as Faker;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Método que insere dados de teste no banco
     */
    public function run(): void
    {
        $faker = Faker::create();
        $table = $this->table('users');

        foreach (range(1, 20) as $value) {
            $user = new UserEntityFactory;
            $table->insert($user($faker))->save();
        }
    }
}
