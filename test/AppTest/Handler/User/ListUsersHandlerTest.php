<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Handler\User\ListUsersHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ListUsersHandlerTest extends TestCase
{
    /** @var ListUsersHandler */
    private $listUsers;

    protected function setUp()
    {
        $this->listUsers = $this->getMockBuilder(ListUsersHandler::class)
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
    }

    /**
     * Testa retorno json no handler de todos os usuários
     */
    public function testReturnsJsonResponseGetAllUsersHandler()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $this->listUsers->method('handle')
            ->willReturn(new JsonResponse([]));

        $response = $this->listUsers->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}