<?php

declare(strict_types=1);

namespace AppTest\Unitary\Entity;

use App\Entity\UserEntity;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    /** @var UserEntity */
    private $user;

    public function setUp()
    {
        $this->user = new UserEntity();
    }

    public function testGetSetId()
    {
        $this->assertInstanceOf(UserEntity::class, $this->user->setId(1));
        $this->assertEquals(1, $this->user->getId());
        $this->assertInternalType('integer', $this->user->getId());
    }

    public function testGetSetName()
    {
        $this->assertInstanceOf(UserEntity::class, $this->user->setName('Usuário Teste'));
        $this->assertEquals('Usuário Teste', $this->user->getName());
        $this->assertInternalType('string', $this->user->getName());
    }

    public function testGetSetEmail()
    {
        $this->assertInstanceOf(UserEntity::class, $this->user->setEmail('teste@email.com'));
        $this->assertEquals('teste@email.com', $this->user->getEmail());
        $this->assertInternalType('string', $this->user->getEmail());
    }

    public function testGetSetPassword()
    {
        $this->assertInstanceOf(UserEntity::class, $this->user->setPassword('xbh46qkhgdu'));
        $this->assertEquals('xbh46qkhgdu', $this->user->getPassword());
        $this->assertInternalType('string', $this->user->getPassword());
    }

    public function testGetSetTimestamp()
    {
        $data = new \DateTime();

        $this->assertInstanceOf(UserEntity::class, $this->user->setCreatedAt($data->format('Y-m-d')));
        $this->assertEquals($data->format('Y-m-d'), $this->user->getCreatedAt());
        $this->assertInternalType('string', $this->user->getCreatedAt());

        $this->assertInstanceOf(UserEntity::class, $this->user->setUpdatedAt($data->format('Y-m-d')));
        $this->assertEquals($data->format('Y-m-d'), $this->user->getUpdatedAt());
        $this->assertInternalType('string', $this->user->getUpdatedAt());
    }

    public function testGetArray()
    {
        $data = new \DateTime();

        $this->user->setId(1)
            ->setName('Usuário Teste')
            ->setEmail('teste@email.com')
            ->setPassword('xbh46qkhgdu')
            ->setCreatedAt($data->format('Y-m-d'))
            ->setUpdatedAt($data->format('Y-m-d'));

        $reflector = new \ReflectionClass(UserEntity::class);

        $this->assertEquals(6, count($reflector->getProperties()));
        $this->assertInternalType('array', $this->user->getArrayCopy());
    }
}