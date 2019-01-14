<?php

declare(strict_types=1);

namespace AppTest\Unitary\Action\User;

use App\Action\User\GetAllUsersAction;
use App\Database\Factory\UserEntityFactory;
use App\Formatter\User\GetAllUsersFormatter;
use App\Repository\UserRepository;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class GetAllUsersActionTest extends TestCase
{
    /** @var int */
    const QUANTIDADE = 20;

    /** @var UserRepository */
    private $repository;

    /** @var GetAllUsersFormatter */
    private $formatter;

    /** @var GetAllUsersAction */
    private $action;

    /** @var Generator */
    private $faker;

    protected function setUp()
    {
        /** @var UserRepository $repository */
        $this->repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var GetAllUsersFormatter $formatter */
        $this->formatter = $this->getMockBuilder(GetAllUsersFormatter::class)
            ->disableOriginalConstructor()
            ->setMethods(['format'])
            ->getMock();

        $this->action = new GetAllUsersAction($this->formatter, $this->repository);

        $this->faker = Faker::create();
    }

    /**
     * @dataProvider providerActionGetAllUsersAction
     * @throws \Exception
     */
    public function testActionGetAllUsersAction(int $limit, int $offset, int $expected)
    {
        $usersArray = array();

        foreach (range(1, (self::QUANTIDADE - $limit)) as $key => $value) {
            if ($offset > $key) {
                continue;
            }

            $user = new UserEntityFactory;
            array_push($usersArray, $user($this->faker, 'array'));
        }

        $this->formatter->method('format')
            ->willReturn($usersArray);

        $users = $this->action->action($limit, $offset);

        $this->assertInternalType('array', $users);
        $this->assertEquals($expected, count($users));
    }

    /**
     * @return array
     */
    public function providerActionGetAllUsersAction()
    {
        return [
            ['limit' => 0, 'offset' => 0, 'expected' => self::QUANTIDADE],
            ['limit' => 10, 'offset' => 0, 'expected' => 10],
            ['limit' => 0, 'offset' => 10, 'expected' => 10],
            ['limit' => 10, 'offset' => 5, 'expected' => 5],
            ['limit' => 10, 'offset' => 10, 'expected' => 0]
        ];
    }
}