<?php

declare(strict_types=1);

namespace AppTest\Integration\Action\User;

use App\Action\User\GetUserAction;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use AppTest\Integration\AbstractTestIntegration;

class GetUserActionTest extends AbstractTestIntegration
{
    /** @var string  */
    const PRIMARY_KEY = 'id';

    /** @var string  */
    const TABLE = 'users';

    /** @var string  */
    const ENTITY = UserEntity::class;

    /** @var UserRepository */
    private $repository;

    /** @var GetUserAction */
    private $action;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $this->connection);

        $this->action = new GetUserAction($this->repository);
    }

    public function testActionGetUserAction()
    {
        $user = $this->action->execute(5);

        $this->assertInternalType('array', $user);
        $this->assertEquals(5, $user['id']);
        $this->assertTrue(array_key_exists('name', $user));
        $this->assertTrue(array_key_exists('password', $user));
        $this->assertTrue(array_key_exists('email', $user));
        $this->assertTrue(array_key_exists('created_at', $user));
        $this->assertTrue(array_key_exists('updated_at', $user));
    }
}