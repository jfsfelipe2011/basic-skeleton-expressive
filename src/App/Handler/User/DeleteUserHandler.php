<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Action\User\DestroyUserAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class DeleteUserHandler implements RequestHandlerInterface
{
    /** @var DestroyUserAction  */
    private $action;

    /**
     * DeleteUserHandler constructor.
     *
     * @param DestroyUserAction $action
     */
    public function __construct(DestroyUserAction $action)
    {
        $this->action = $action;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');

        try {
            $this->action->action((int) $id);
            return new JsonResponse(['success' => 'Usuário excluido com sucesso'], 200);
        } catch (\Exception $exception) {
            return new JsonResponse(['errors' => [ 'runtime' => $exception->getMessage()]], 400);
        }
    }
}