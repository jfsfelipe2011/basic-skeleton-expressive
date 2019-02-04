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

    /**
     * Método setUp do teste de repositorio de usuário
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $this->connection);

        $this->faker = Faker::create();
    }

    /**
     * Teste de sucesso ao buscar todos os usuário
     */
    public function testFindAllUsersReturnSuccess()
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
     * Teste de sucesso ao buscar um usuário
     */
    public function testFindUserReturnSuccess()
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
     * Teste de sucesso ao inserir um usuário
     *
     * @throws \Exception
     */
    public function testInsertUserReturnSuccess()
    {
        $userFactory = new UserEntityFactory();
        $data = $userFactory($this->faker, 'array');

        $userCreate = $this->repository->insert($data);

        $user = $this->repository->find((int) $userCreate['id']);

        $this->assertInstanceOf(UserEntity::class, $user);
    }

    /**
     * Teste de sucesso ao update de um usuário
     *
     * @throws \Exception
     */
    public function testUpdateUserReturnSuccess()
    {
        $id = mt_rand(1, 10);

        $data = [
            'name'       => 'Teste da Silva',
            'updated_at' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        /** @var UserEntity $user */
        $user = $this->repository->find($id);
        $nome = $user->getName();

        $userUpdate = $this->repository->update($id, $data);

        $this->assertNotEquals($nome, $userUpdate['name']);
    }

    /**
     * Teste de sucesso ao deletar um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    public function testDeleteUserReturnSuccess()
    {
        $userFactory = new UserEntityFactory();
        $data = $userFactory($this->faker, 'array');

        $userCreate = $this->repository->insert($data);

        $delete = $this->repository->delete((int) $userCreate['id']);

        $this->assertInternalType('boolean', $delete);
        $this->assertTrue($delete);
    }

    /**
     * Teste retorno string na tabela
     */
    public function testGetTableReturnString()
    {
        $table = $this->repository->getTable();

        $this->assertInternalType('string', $table);
        $this->assertEquals(self::TABLE, $table);
    }

    /**
     * Teste retorno string na chave primaria
     */
    public function testGetPrimaryKeyReturnString()
    {
        $primaryKey = $this->repository->getPrimaryKey();

        $this->assertInternalType('string', $primaryKey);
        $this->assertEquals(self::PRIMARY_KEY, $primaryKey);
    }

    /**
     * Teste retorno integer nas linhas afetadas
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function testGetAffectedRowsReturnInt()
    {
        $userFactory = new UserEntityFactory();
        $data = $userFactory($this->faker, 'array');

        $this->repository->insert($data);
        $rows = $this->repository->getAffectedRows();

        $this->assertInternalType('integer', $rows);
        $this->assertEquals(1, $rows);
    }

    /**
     * Teste retorno falso caso não exista o usuário
     */
    public function testFindUserReturnFalse()
    {
        $id = $this->repository->getLastUserId();
        $id++;

        $user = $this->repository->find($id);

        $this->assertInternalType('boolean', $user);
        $this->assertFalse($user);
    }

    /**
     * Teste retorno falso caso não seja informado nenhum valor para insert
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testInsertUserReturnFalse()
    {
        $user = $this->repository->insert([]);

        $this->assertInternalType('boolean', $user);
        $this->assertFalse($user);
    }

    /**
     * Teste retorno falso caso não seja informado nenhum valor de update
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testUpdateUserReturnFalse()
    {
        $user = $this->repository->update(1, []);

        $this->assertInternalType('boolean', $user);
        $this->assertFalse($user);
    }

    /**
     * Teste retorno falso ao deletar um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function testDeleteUserReturnFalse()
    {
        $id = $this->repository->getLastUserId();
        $id++;

        $delete = $this->repository->delete($id);

        $this->assertInternalType('boolean', $delete);
        $this->assertFalse($delete);
    }

    /**
     * Teste retorno integer ao buscar o último id da tabela usuários
     */
    public function testGetLastUserIdReturnInt()
    {
        $id = $this->repository->getLastUserId();

        $this->assertInternalType('integer', $id);
    }
}