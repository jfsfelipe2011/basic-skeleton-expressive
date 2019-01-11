<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\GetAllUsersAction;
use App\Handler\User\ListUsersHandler;
use Psr\Container\ContainerInterface;

class ListUsersHandlerFactory
{
    /**
     * Cria um novo handler de lista de usuários
     *
     * @param ContainerInterface $container
     * @return ListUsersHandler
     */
    public function __invoke(ContainerInterface $container): ListUsersHandler
    {
        $action = $container->get(GetAllUsersAction::class);

        return new ListUsersHandler($action);
    }
}
