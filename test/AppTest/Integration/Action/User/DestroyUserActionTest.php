<?php

declare(strict_types=1);

namespace AppTest\Integration\Action\User;

use App\Action\User\DestroyUserAction;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use AppTest\Integration\AbstractTestIntegration;

class DestroyUserActionTest extends AbstractTestIntegration
{
    /** @var string  */
    const PRIMARY_KEY = 'id';

    /** @var string  */
    const TABLE = 'users';

    /** @var string  */
    const ENTITY = UserEntity::class;

    /** @var UserRepository */
    private $repository;

    /** @var DestroyUserAction */
    private $action;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $this->connection);

        $this->action = new DestroyUserAction($this->repository);
    }

    /**
     * Testa ação de deleção de usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function testActionDestroyUserAction()
    {
        $id = $this->repository->getLastUserId();

        $delete = $this->action->execute($id);

        $this->assertInternalType('boolean', $delete);
        $this->assertTrue($delete);
    }

    /**
     * @expectedException \Exception
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function testActionDestroyUserActionReturnException()
    {
        $id = $this->repository->getLastUserId();
        $id++;

        $this->action->execute($id);
    }
}