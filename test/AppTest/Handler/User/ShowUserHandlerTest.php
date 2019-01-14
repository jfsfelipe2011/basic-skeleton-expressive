<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Action\User\GetUserAction;
use App\Handler\User\ShowUserHandler;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ShowUserHandlerTest
{
    /** @var GetUserAction */
    private $action;

    protected function setUp()
    {
        $this->action = $this->prophesize(GetUserAction::class);
    }

    /**
     * Testa o retorno json no handler de um usuário
     */
    public function testReturnsJsonResponseGetUserHandler()
    {
        $getUser = new ShowUserHandler($this->action->reveal());

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $getUser->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}