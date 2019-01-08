<?php

namespace App\Handler\User;

use App\Action\User\GetAllUsersAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetAllUsersHandler implements RequestHandlerInterface
{
    private $action;

    public function __construct(GetAllUsersAction $action)
    {
        $this->action = $action;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->action->action());
    }
}