<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Action\User\GetAllUsersAction;
use App\Handler\User\ListUsersHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetAllUsersHandlerTest extends TestCase
{
    /** @var GetAllUsersAction */
    private $action;

    protected function setUp()
    {
        $this->action = $this->prophesize(GetAllUsersAction::class);
    }

    /**
     * Testa retorno json no handler de todos os usuários
     */
    public function testReturnsJsonResponseGetAllUsersHandler()
    {
        $getAllUsers = new ListUsersHandler($this->action->reveal());

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $getAllUsers->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}