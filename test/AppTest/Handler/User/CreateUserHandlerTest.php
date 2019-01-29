<?php

declare(strict_types=1);

namespace AppTest\Handler\User;

use App\Action\User\AddUserAction;
use App\Formatter\Validation\ErrorArrayFormatter;
use App\Handler\User\CreateUserHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class CreateUserHandlerTest extends TestCase
{
    /** @var AddUserAction */
    private $action;

    /** @var ErrorArrayFormatter */
    private $formatter;

    protected function setUp()
    {
        $this->action    = $this->prophesize(AddUserAction::class);
        $this->formatter = $this->prophesize(ErrorArrayFormatter::class);
    }

    /**
     * Testa retorno json para a criação de usuário
     */
    public function testReturnsJsonResponseCreateUserHandler()
    {
        $createUser = new CreateUserHandler($this->action->reveal(), $this->formatter->reveal());

        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();

        $response = $createUser->handle($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}