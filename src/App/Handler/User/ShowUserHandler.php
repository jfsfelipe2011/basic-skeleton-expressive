<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Action\User\GetUserAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShowUserHandler implements RequestHandlerInterface
{
    /** @var GetUserAction  */
    private $action;

    /**
     * GetUserHandler constructor.
     * @param GetUserAction $action
     */
    public function __construct(GetUserAction $action)
    {
        $this->action = $action;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');

        var_dump($id);
    }
}