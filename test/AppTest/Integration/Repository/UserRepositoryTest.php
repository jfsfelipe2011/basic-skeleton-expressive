<?php

declare(strict_types=1);

namespace AppTest\Integration\Repository;

use App\Database\Factory\UserEntityFactory;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use AppTest\Integration\AbstractTestIntegration;
use Faker\Generator;
use Faker\Factory as Faker;

class UserRepositoryTest extends AbstractTestIntegration
{
    /** @var string  */
    const PRIMARY_KEY = 'id';

    /** @var string  */
    const TABLE = 'users';

    /** @var string  */
    const ENTITY = UserEntity::class;

    /** @var UserRepository */
    private $repository;

    /** @var Generator */
    private $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $this->connection);

        $this->faker = Faker::create();
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
            ['limit' => 5, 'offset' => 15, 'expected' => 5]
        ];
    }

    /**
     * Testa a busca de um usuário
     */
    public function testFindUser()
    {
        $id = mt_rand(1, 10);

        $user = $this->repository->find($id);

        $this->assertInstanceOf(UserEntity::class, $user);
        $this->assertEquals($id, $user->getId());
        $this->assertTrue(property_exists($user, 'id'));
        $this->assertTrue(property_exists($user, 'name'));
        $this->assertTrue(property_exists($user, 'email'));
        $this->assertTrue(property_exists($user, 'password'));
        $this->assertTrue(property_exists($user, 'created_at'));
        $this->assertTrue(property_exists($user, 'updated_at'));
    }

    /**
     * Testa a criação de um usuário
     *
     * @throws \Exception
     */
    public function testInsertUser()
    {
        $userFactory = new UserEntityFactory();
        $data = $userFactory($this->faker, 'array');

        $userCreate = $this->repository->insert($data);

        $user = $this->repository->find((int) $userCreate['id']);

        $this->assertInstanceOf(UserEntity::class, $user);
    }
}