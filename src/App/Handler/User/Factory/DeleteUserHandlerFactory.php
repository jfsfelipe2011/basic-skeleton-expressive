<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\DestroyUserAction;
use App\Handler\User\DeleteUserHandler;
use Psr\Container\ContainerInterface;

class DeleteUserHandlerFactory
{
    /**
     * Cria um novo handler de deleção de usuário
     *
     * @param ContainerInterface $container
     * @return DeleteUserHandler
     */
    public function __invoke(ContainerInterface $container): DeleteUserHandler
    {
        $action = $container->get(DestroyUserAction::class);

        return new DeleteUserHandler($action);
    }
}
