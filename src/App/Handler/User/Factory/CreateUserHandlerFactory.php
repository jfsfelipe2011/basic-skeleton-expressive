<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\AddUserAction;
use App\Formatter\Validation\ErrorArrayFormatter;
use App\Handler\User\CreateUserHandler;
use Psr\Container\ContainerInterface;

class CreateUserHandlerFactory
{
    /**
     * Cria um novo handler de create
     *
     * @param ContainerInterface $container
     * @return CreateUserHandler
     */
    public function __invoke(ContainerInterface $container): CreateUserHandler
    {
        $action    = $container->get(AddUserAction::class);
        $formatter = $container->get(ErrorArrayFormatter::class);

        return new CreateUserHandler($action, $formatter);
    }
}