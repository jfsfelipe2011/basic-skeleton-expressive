<?php

declare(strict_types=1);

namespace AppTest\Unitary\Action;

use App\Action\User\AddUserAction;
use App\Database\Factory\UserEntityFactory;
use App\Filter\UserFilter;
use App\Formatter\Validation\ErrorStringFormatter;
use App\Repository\UserRepository;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class AddUserActionTest extends TestCase
{
    /** @var UserRepository */
    private $repository;

    /** @var UserFilter */
    private $filter;

    /** @var ErrorStringFormatter */
    private $formatter;

    /** @var AddUserAction */
    private $action;

    /** @var Generator */
    private $faker;

    protected function setUp()
    {
        /** @var UserRepository $repository */
        $this->repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['insert'])
            ->getMock();

        $this->filter = $this->getMockBuilder(UserFilter::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var ErrorStringFormatter $formatter */
        $this->formatter = $this->getMockBuilder(ErrorStringFormatter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->action = new AddUserAction($this->repository, $this->filter, $this->formatter);

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

        $this->repository->method('insert')
            ->willReturn($userMock);

        $user = $this->repository->insert([]);

        $this->assertEquals($id, $user['id']);
        $this->assertTrue(array_key_exists('name', $user));
        $this->assertTrue(array_key_exists('password', $user));
        $this->assertTrue(array_key_exists('email', $user));
        $this->assertTrue(array_key_exists('created_at', $user));
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     */
    public function testExceptionIsNotValidDataAddUserAction()
    {
        $this->repository->method('insert')
            ->will($this->throwException(new \InvalidArgumentException));

        $this->repository->insert([]);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionIsNotInsertAddUserAction()
    {
        $this->repository->method('insert')
            ->will($this->throwException(new \RuntimeException));

        $this->repository->insert([]);
    }
}