<?php

declare(strict_types=1);

namespace AppTest\Unitary\Formatter;

use App\Database\Factory\UserEntityFactory;
use App\Entity\UserEntity;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class GetAllUsersFormatterTest extends TestCase
{
    private $faker;

    protected function setUp()
    {
        $this->faker  = Faker::create();
    }

    /**
     * @throws \Exception
     */
    public function testFormatGetAllUsersComTodosRegistrosSendoUsersEntity()
    {
        $users = array();

        foreach (range(1, 20) as $value) {
            $user = new UserEntityFactory;
            array_push($users, $user($this->faker, 'objeto'));
        }

        foreach ($users as $user) {
            $this->assertInstanceOf(UserEntity::class, $user);
        }
    }
}