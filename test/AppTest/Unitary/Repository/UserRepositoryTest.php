<?php

declare(strict_types=1);

namespace AppTest\Unitary\Repository;

use App\Database\Factory\UserEntityFactory;
use App\Repository\UserRepository;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class UserRepositoryTest extends TestCase
{
    /** @var UserRepository */
    private $repository;

    /** @var Generator */
    private $faker;

    /**
     * setUp de teste de repositório de usuário
     */
    protected function setUp()
    {
        $this->repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findAll',
                          'find',
                          'insert',
                          'update',
                          'delete',
                          'getTable',
                          'getPrimaryKey',
                          'getAffectedRows',
                          'getLastUserId'])
            ->getMock();

        $this->faker = Faker::create();
    }

    /**
     * Testa o retorno de sucesso ao procurar todos os usuário
     *
     * @dataProvider providerFindAllUsers
     * @throws \Exception
     */
    public function testFindAllUsersReturnSuccess(int $quantidade, $limit, $offset, int $expected)
    {
        $this->repository->method('findAll')
            ->willReturn($this->createUsers($quantidade, $limit, $offset));

        $users = $this->repository->findAll();

        $this->assertEquals($expected, count($users));
        $this->assertInternalType('array', $users);
    }

    /**
     * Cria alguns mocks de usuários para teste
     *
     * @return array
     * @throws \Exception
     */
    private function createUsers(int $quantidade, $limit = null, $offset = 1): array
    {
        if ($limit) {
            $quantidade -= $limit;
        }

        $i = 1;
        $users = array();

        while ($i <= $quantidade) {
            if ($offset >= $i) {
                $i++;
                continue;
            }

            $firstname = $this->faker->firstname;
            $lastname  = $this->faker->lastname;

            $user = new \stdClass();
            $user->id         = $i;
            $user->name       = $firstname . ' ' . $lastname;
            $user->email      = $firstname . '.' . $lastname . '@teste.com';
            $user->password   = md5($this->faker->word);
            $user->created_at = (new \DateTime)->format('Y-m-d H:i:s');
            $user->updated_at = null;

            array_push($users, $user);
            $i++;
        }

        return $users;
    }

    /**
     * Provider para teste de retorno de sucesso ao procurar todos os usuário
     *
     * @return array
     */
    public function providerFindAllUsers()
    {
        return [
            ['quantidade' => 20, 'limit' => null, 'offset' => null, 'expected' => 20],
            ['quantidade' => 20, 'limit' => 0, 'offset' => null, 'expected' => 20],
            ['quantidade' => 10, 'limit' => 0, 'offset' => null, 'expected' => 10],
            ['quantidade' => 10, 'limit' => 5, 'offset' => null, 'expected' => 5],
            ['quantidade' => 10, 'limit' => 0, 'offset' => 5, 'expected' => 5],
            ['quantidade' => 10, 'limit' => 5, 'offset' => 5, 'expected' => 0]
        ];
    }

    /**
     * Testa o retorno de sucesso ao procurar um usuário
     *
     * @throws \Exception
     */
    public function testFindUserReturnSuccess()
    {
        $id = $this->faker->randomDigit();

        $this->repository->method('find')
            ->willReturn($this->createUser($id));

        $user = $this->repository->find($id);

        $this->assertEquals($id, $user->id);
        $this->assertTrue(property_exists($user, 'id'));
        $this->assertTrue(property_exists($user, 'name'));
        $this->assertTrue(property_exists($user, 'email'));
        $this->assertTrue(property_exists($user, 'password'));
        $this->assertTrue(property_exists($user, 'created_at'));
        $this->assertTrue(property_exists($user, 'updated_at'));
    }

    /**
     * Cria um mock de usuário para testes
     *
     * @param int $id
     * @return \stdClass
     * @throws \Exception
     */
    private function createUser(int $id)
    {
        $firstname = $this->faker->firstname;
        $lastname  = $this->faker->lastname;

        $user = new \stdClass();
        $user->id         = $id;
        $user->name       = $firstname . ' ' . $lastname;
        $user->email      = $firstname . '.' . $lastname . '@teste.com';
        $user->password   = md5($this->faker->word);
        $user->created_at = (new \DateTime)->format('Y-m-d H:i:s');
        $user->updated_at = null;

        return $user;
    }

    /**
     * Testa o retorno de sucesso ao inserir um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function testInsertUserReturnSuccess()
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
     * Testa o retorno de sucesso ao alterar um usuário
     *
     * @throws \Exception
     */
    public function testUpdateUserReturnSuccess()
    {
        $id = $this->faker->randomDigit();

        $userFactory = new UserEntityFactory();
        $userMock = $userFactory($this->faker, 'array');
        $userMock['id'] = $id;

        $nome = $userMock['name'];

        $userMock['name'] = 'Teste da Silva';

        $this->repository->method('update')
            ->willReturn($userMock);

        $user = $this->repository->update($id, []);

        $this->assertNotEquals($nome, $user['name']);
    }

    /**
     * Testa o retorno de sucesso ao deletar um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function testDeleteUserReturnSuccess()
    {
        $id = $this->faker->randomDigit();

        $this->repository->method('delete')
            ->willReturn(true);

        $delete = $this->repository->delete($id);

        $this->assertInternalType('boolean', $delete);
        $this->assertTrue($delete);
    }

    /**
     * Teste retorno string do método da tabela
     */
    public function testGetTableReturnString()
    {
        $this->repository->method('getTable')
            ->willReturn('users');

        $table = $this->repository->getTable();

        $this->assertInternalType('string', $table);
        $this->assertEquals('users', $table);
    }

    /**
     * Teste retorno string do método de chave primária
     */
    public function testGetPrimaryKeyReturnString()
    {
        $this->repository->method('getPrimaryKey')
            ->willReturn('id');

        $primaryKey = $this->repository->getPrimaryKey();

        $this->assertInternalType('string', $primaryKey);
        $this->assertEquals('id', $primaryKey);
    }

    /**
     * Teste retorno int do método de linhas afetadas
     */
    public function testGetAffectedRowsReturnInt()
    {
        $this->repository->method('getAffectedRows')
            ->willReturn(1);

        $rows = $this->repository->getAffectedRows();

        $this->assertInternalType('integer', $rows);
        $this->assertEquals(1, $rows);
    }

    /**
     * Teste retorno falso quando não existe usuário
     */
    public function testFindUserReturnFalse()
    {
        $id = $this->faker->randomDigit();

        $this->repository->method('find')
            ->willReturn(false);

        $user = $this->repository->find($id);

        $this->assertInternalType('boolean', $user);
        $this->assertFalse($user);
    }

    /**
     * Teste retorno falso quando não inserido um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testInsertUserReturnFalse()
    {
        $this->repository->method('insert')
            ->willReturn(false);

        $user = $this->repository->insert([]);

        $this->assertInternalType('boolean', $user);
        $this->assertFalse($user);
    }

    /**
     * Teste retorno falso quando não altera um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testUpdateUserReturnFalse()
    {
        $id = $this->faker->randomDigit();

        $this->repository->method('update')
            ->willReturn(false);

        $user = $this->repository->update($id, []);

        $this->assertInternalType('boolean', $user);
        $this->assertFalse($user);
    }

    /**
     * Teste retorno falso quando não deleta um usuário
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testDeleteUserReturnFalse()
    {
        $id = $this->faker->randomDigit();

        $this->repository->method('delete')
            ->willReturn(false);

        $delete = $this->repository->delete($id);

        $this->assertInternalType('boolean', $delete);
        $this->assertFalse($delete);
    }

    /**
     * Teste retorno inteiro no método de ultimo id de usuário
     */
    public function testGetLastUserIdReturnInt()
    {
        $this->repository->method('getLastUserId')
            ->willReturn(5);

        $id = $this->repository->getLastUserId();

        $this->assertInternalType('integer', $id);
        $this->assertEquals(5, $id);
    }
}