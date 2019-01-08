<?php

namespace App\Handler\User\Factory;

use App\Action\User\GetAllUsersAction;
use App\Handler\User\GetAllUsersHandler;
use Psr\Container\ContainerInterface;

class GetAllUsersHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $action = $container->get(GetAllUsersAction::class);

        return new GetAllUsersHandler($action);
    }
}