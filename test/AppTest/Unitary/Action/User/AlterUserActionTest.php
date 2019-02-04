<?php

declare(strict_types=1);

namespace AppTest\Unitary\Action\User;

use App\Action\User\AlterUserAction;
use App\Database\Factory\UserEntityFactory;
use PHPUnit\Framework\TestCase;
use Faker\Generator;
use Faker\Factory as Faker;

class AlterUserActionTest extends TestCase
{
    /** @var AlterUserAction */
    private $action;

    /** @var Generator */
    private $faker;

    protected function setUp()
    {
        $this->action = $this->getMockBuilder(AlterUserAction::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $this->faker = Faker::create();
    }

    /**
     * Teste de ação de update de usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function testActionAlterUserAction()
    {
        $id = $this->faker->randomDigit();

        $userFactory = new UserEntityFactory();
        $userMock = $userFactory($this->faker, 'array');
        $userMock['id'] = $id;

        $nome = $userMock['name'];

        $userMock['name'] = 'Teste da Silva';

        $this->action->method('execute')
            ->willReturn($userMock);

        $user = $this->action->execute($id, []);

        $this->assertNotEquals($nome, $user['name']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testExceptionIsNotValidDataAlterUserAction()
    {
        $id = $this->faker->randomDigit();

        $this->action->method('execute')
            ->will($this->throwException(new \InvalidArgumentException));

        $this->action->execute($id, []);
    }

    /**
     * @expectedException \RuntimeException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testExceptionIsNotUpdateAlterUserAction()
    {
        $id = $this->faker->randomDigit();

        $this->action->method('execute')
            ->will($this->throwException(new \RuntimeException));

        $this->action->execute($id, []);
    }
}