<?php

declare(strict_types=1);

namespace AppTest\Integration\Action\User;

use App\Action\User\GetAllUsersAction;
use App\Entity\UserEntity;
use App\Formatter\User\GetAllUsersFormatter;
use App\Repository\UserRepository;
use AppTest\Integration\AbstractTestIntegration;

class GetAllUsersActionTest extends AbstractTestIntegration
{
    /** @var string  */
    const PRIMARY_KEY = 'id';

    /** @var string  */
    const TABLE = 'users';

    /** @var string  */
    const ENTITY = UserEntity::class;

    /** @var UserRepository */
    private $repository;

    /** @var GetAllUsersFormatter */
    private $formatter;

    /** @var GetAllUsersAction */
    private $action;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $this->connection);
        $this->formatter  = new GetAllUsersFormatter();

        $this->action = new GetAllUsersAction($this->formatter, $this->repository);
    }

    public function testActionGetAllUsersAction()
    {
        $users = $this->action->action(0, 0);

        $this->assertInternalType('array', $users);
    }


    /**
     * @dataProvider providerActionGetAllUsersActionLimitOffset
     */
    public function testActionGetAllUsersActionLimitOffset(int $limit, int $offset, int $expected)
    {
        $users = $this->action->action($limit, $offset);

        $this->assertInternalType('array', $users);
        $this->assertEquals($expected, count($users));
    }

    /**
     * @return array
     */
    public function providerActionGetAllUsersActionLimitOffset()
    {
        return [
            ['limit' => 20, 'offset' => 0, 'expected' => 20],
            ['limit' => 10, 'offset' => 0, 'expected' => 10],
            ['limit' => 10, 'offset' => 10, 'expected' => 10]
        ];
    }
}