<?php

declare(strict_types=1);

namespace AppTest\Unitary\Repository;

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
            ->setMethods(['findAll'])
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
}