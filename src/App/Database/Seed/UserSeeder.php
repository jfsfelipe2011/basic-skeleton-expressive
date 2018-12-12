<?php

use App\Database\Factory\UserEntityFactory;
use Faker\Factory as Faker;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Faker::create();
        $table = $this->table('users');

        foreach (range(1, 20) as $value) {
            $user = new UserEntityFactory;
            $table->insert($user($faker))->save();
        }
    }
}
