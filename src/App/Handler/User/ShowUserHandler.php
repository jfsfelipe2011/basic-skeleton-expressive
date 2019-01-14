<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Action\User\GetUserAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

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

    /**
     * Mostra o usuário passado por parametro
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');

        $user = $this->action->action((int) $id);

        if (!$user) {
            return new JsonResponse([
                'mensagem' => 'Usuário não encontrado'
            ], 404);
        }

        return new JsonResponse($user);
    }
}