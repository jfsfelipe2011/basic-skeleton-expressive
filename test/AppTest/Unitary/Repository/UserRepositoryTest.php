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

    protected function setUp()
    {
        $this->repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findAll', 'find', 'insert', 'update'])
            ->getMock();

        $this->faker = Faker::create();
    }

    /**
     * @dataProvider providerFindAllUsers
     * @throws \Exception
     */
    public function testFindAllUsers(int $quantidade, $limit, $offset, int $expected)
    {
        $this->repository->method('findAll')
            ->willReturn($this->createUsers($quantidade, $limit, $offset));

        $users = $this->repository->findAll();

        $this->assertEquals($expected, count($users));
        $this->assertInternalType('array', $users);
    }

    /**
     * Create mock users
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
     * @throws \Exception
     */
    public function testFindUser()
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
     * Create mock user
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
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function testInsertUser()
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
     * @throws \Exception
     */
    public function testUpdateUser()
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
}