<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Handler\User\DeleteUserHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class DeleteUserHandlerTest extends TestCase
{
    /** @var DeleteUserHandler */
    private $deleteUser;

    protected function setUp()
    {
        $this->deleteUser = $this->getMockBuilder(DeleteUserHandler::class)
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
    }

    /**
     * Testa retorno json para a deleção de usuário
     */
    public function testReturnsJsonResponseDeleteUserHandler()
    {
        $this->deleteUser->method('handle')
            ->willReturn(new JsonResponse([]));

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $this->deleteUser->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}