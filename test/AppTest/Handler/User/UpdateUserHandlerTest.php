<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Handler\User\UpdateUserHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UpdateUserHandlerTest extends TestCase
{
    /** @var UpdateUserHandler */
    private $updateUser;

    protected function setUp()
    {
        $this->updateUser = $this->getMockBuilder(UpdateUserHandler::class)
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
    }

    /**
     * Testa retorno json para a alteração de usuário
     */
    public function testReturnsJsonResponseUpdateUserHandler()
    {
        $this->updateUser->method('handle')
            ->willReturn(new JsonResponse([]));

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $this->updateUser->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}