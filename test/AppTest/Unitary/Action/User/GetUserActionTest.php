<?php

declare(strict_types=1);

namespace AppTest\Unitary\Action;

use App\Action\User\GetUserAction;
use App\Database\Factory\UserEntityFactory;
use App\Repository\UserRepository;
use Faker\Generator;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;

class GetUserActionTest extends TestCase
{
    /** @var UserRepository */
    private $repository;

    /** @var Generator */
    private $faker;

    /** @var GetUserAction */
    private $action;

    protected function setUp()
    {
        /** @var UserRepository $repository */
        $this->repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->action = new GetUserAction($this->repository);

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

        $this->repository->method('find')
            ->willReturn($userMock);

        $user = $this->repository->find($id);

        $this->assertEquals($id, $user['id']);
        $this->assertTrue(array_key_exists('name', $user));
        $this->assertTrue(array_key_exists('password', $user));
        $this->assertTrue(array_key_exists('email', $user));
        $this->assertTrue(array_key_exists('created_at', $user));
        $this->assertTrue(array_key_exists('updated_at', $user));
    }
}