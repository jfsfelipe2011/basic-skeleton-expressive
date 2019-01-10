<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\GetAllUsersAction;
use App\Handler\User\GetAllUsersHandler;
use Psr\Container\ContainerInterface;

class GetAllUsersHandlerFactory
{
    /**
     * Cria um novo handler de lista de usuários
     *
     * @param ContainerInterface $container
     * @return GetAllUsersHandler
     */
    public function __invoke(ContainerInterface $container): GetAllUsersHandler
    {
        $action = $container->get(GetAllUsersAction::class);

        return new GetAllUsersHandler($action);
    }
}
