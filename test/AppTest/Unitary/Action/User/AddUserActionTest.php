<?php

declare(strict_types=1);

namespace AppTest\Unitary\Action;

use App\Action\User\AddUserAction;
use App\Database\Factory\UserEntityFactory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class AddUserActionTest extends TestCase
{
    /** @var AddUserAction */
    private $action;

    /** @var Generator */
    private $faker;

    protected function setUp()
    {
        /** @var AddUserAction $action */
        $this->action = $this->getMockBuilder(AddUserAction::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $this->faker = Faker::create();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function testActionAddUserAction()
    {
        $id = $this->faker->randomDigit();

        $userFactory = new UserEntityFactory();
        $userMock = $userFactory($this->faker, 'array');
        $userMock['id'] = $id;

        $this->action->method('execute')
            ->willReturn($userMock);

        $user = $this->action->execute([]);

        $this->assertEquals($id, $user['id']);
        $this->assertTrue(array_key_exists('name', $user));
        $this->assertTrue(array_key_exists('password', $user));
        $this->assertTrue(array_key_exists('email', $user));
        $this->assertTrue(array_key_exists('created_at', $user));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testExceptionIsNotValidDataAddUserAction()
    {
        $this->action->method('execute')
            ->will($this->throwException(new \InvalidArgumentException));

        $this->action->execute([]);
    }

    /**
     * @expectedException \RuntimeException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testExceptionIsNotInsertAddUserAction()
    {
        $this->action->method('execute')
            ->will($this->throwException(new \RuntimeException));

        $this->action->execute([]);
    }
}