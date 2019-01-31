<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Handler\User\CreateUserHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class CreateUserHandlerTest extends TestCase
{
    /** @var CreateUserHandler */
    private $createUser;

    protected function setUp()
    {
        $this->createUser = $this->getMockBuilder(CreateUserHandler::class)
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
    }

    /**
     * Testa retorno json para a criação de usuário
     */
    public function testReturnsJsonResponseCreateUserHandler()
    {
        $this->createUser->method('handle')
            ->willReturn(new JsonResponse([]));

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $this->createUser->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}