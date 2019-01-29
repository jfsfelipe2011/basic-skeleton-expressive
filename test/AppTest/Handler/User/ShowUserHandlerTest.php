<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Action\User\GetUserAction;
use App\Handler\User\ShowUserHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ShowUserHandlerTest extends TestCase
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
        $showUser = new ShowUserHandler($this->action->reveal());

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $showUser->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}