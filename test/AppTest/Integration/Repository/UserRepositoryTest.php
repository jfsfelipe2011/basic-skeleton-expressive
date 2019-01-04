<?php

declare(strict_types=1);

namespace AppTest\Integration\Repository;

use App\Entity\UserEntity;
use App\Repository\UserRepository;

class UserRepositoryTest extends AbstractRepositoryTest
{
    /** @var string  */
    const PRIMARY_KEY = 'id';

    /** @var string  */
    const TABLE = 'users';

    /** @var string  */
    const ENTITY = UserEntity::class;

    /** @var UserRepository */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $this->connection);
    }

    public function testFindAllUsers()
    {
        $users = $this->repository->findAll();

        $this->assertInternalType('array', $users);
    }

    /**
     * @dataProvider providerFindAllUsersLimitOffset
     */
    public function testFindAllUsersLimitOffset(int $limit, int $offset, $expected)
    {
        $users = $this->repository->findAll($limit, $offset);

        $this->assertInternalType('array', $users);
        $this->assertEquals($expected, count($users));
    }

    /**
     * @return array
     */
    public function providerFindAllUsersLimitOffset()
    {
        return [
            ['limit' => 10, 'offset' => 0, 'expected' => 10],
            ['limit' => 20, 'offset' => 0, 'expected' => 20],
            ['limit' => 20, 'offset' => 15, 'expected' => 5]
        ];
    }
}