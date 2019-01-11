<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\GetUserAction;
use App\Handler\User\ShowUserHandler;
use Psr\Container\ContainerInterface;

class ShowUserHandlerFactory
{
    /**
     * Cria um novo handler que mostra um user
     *
     * @param ContainerInterface $container
     * @return ShowUserHandler
     */
    public function __invoke(ContainerInterface $container): ShowUserHandler
    {
        $action = $container->get(GetUserAction::class);

        return new ShowUserHandler($action);
    }
}