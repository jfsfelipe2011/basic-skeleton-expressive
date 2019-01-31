<?php

declare(strict_types=1);

namespace AppTest\Unitary\Formatter;

use App\Database\Factory\UserEntityFactory;
use App\Entity\UserEntity;
use App\Formatter\User\GetAllUsersFormatter;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class GetAllUsersFormatterTest extends TestCase
{
    /** @var int */
    const QUANTIDADE = 20;

    /** @var GetAllUsersFormatter */
    private $formatter;

    /** @var Generator */
    private $faker;

    protected function setUp()
    {
        $this->faker     = Faker::create();
        $this->formatter = new GetAllUsersFormatter();
    }

    /**
     * Testa o formatter com todos os registros sendo objetos
     *
     * @throws \Exception
     */
    public function testFormatGetAllUsersComTodosRegistrosSendoUsersEntity()
    {
        $users = array();

        foreach (range(1, self::QUANTIDADE) as $value) {
            $user = new UserEntityFactory;
            array_push($users, $user($this->faker, 'objeto'));
        }

        foreach ($users as $user) {
            $this->assertInstanceOf(UserEntity::class, $user);
        }

        $formatted = $this->formatter->format($users);

        foreach ($formatted as $user) {
            $this->assertInternalType('array', $user);
        }

        $this->assertEquals(self::QUANTIDADE, count($formatted));
    }

    /**
     * Testa o formatter com um registro sendo array
     *
     * @throws \Exception
     */
    public function testFormatGetAllUsersSemTodosRegistrosSendoUsersEntity()
    {
        $users = array();

        foreach (range(1, self::QUANTIDADE) as $value) {
            $user = new UserEntityFactory;
            array_push($users, $user($this->faker, 'objeto'));
        }

        $userArray = new UserEntityFactory;
        array_push($users, $userArray($this->faker, 'array'));

        $this->assertEquals(21, count($users));

        $formatted = $this->formatter->format($users);

        foreach ($formatted as $user) {
            $this->assertInternalType('array', $user);
        }

        $this->assertEquals(self::QUANTIDADE, count($formatted));
    }

    /**
     * Testa retorno de array vazio, quando não formado um array na entrada
     */
    public function testReturnEmptyArrayInNotArrayInformated()
    {
        $formatted = $this->formatter->format('teste');

        $this->assertEquals(0, count($formatted));
        $this->assertInternalType('array', $formatted);
        $this->assertTrue(empty($formatted));
    }
}