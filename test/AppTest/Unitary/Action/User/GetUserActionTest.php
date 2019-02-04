<?php

declare(strict_types=1);

namespace AppTest\Unitary\Action;

use App\Action\User\GetUserAction;
use App\Database\Factory\UserEntityFactory;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use Faker\Generator;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;

class GetUserActionTest extends TestCase
{
    /** @var Generator */
    private $faker;

    /** @var GetUserAction */
    private $action;

    protected function setUp()
    {
        $this->action = $this->getMockBuilder(GetUserAction::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $this->faker = Faker::create();
    }

    /**
     * Testa o retorno de um usuário
     *
     * @throws \Exception
     */
    public function testActionGetUserAction()
    {
        $id = $this->faker->randomDigit();

        $userFactory = new UserEntityFactory();
        $userMock = $userFactory($this->faker, 'array');
        $userMock['id'] = $id;

        $this->action->method('execute')
            ->willReturn($userMock);

        $user = $this->action->execute($id);

        $this->assertEquals($id, $user['id']);
        $this->assertTrue(array_key_exists('name', $user));
        $this->assertTrue(array_key_exists('password', $user));
        $this->assertTrue(array_key_exists('email', $user));
        $this->assertTrue(array_key_exists('created_at', $user));
        $this->assertTrue(array_key_exists('updated_at', $user));
    }
}