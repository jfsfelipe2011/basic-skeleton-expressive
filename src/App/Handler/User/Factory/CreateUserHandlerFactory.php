<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\InsertUserAction;
use App\Formatter\Validation\ErrorArrayFormatter;
use App\Handler\User\CreateUserHandler;
use Psr\Container\ContainerInterface;

class CreateUserHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $action    = $container->get(InsertUserAction::class);
        $formatter = $container->get(ErrorArrayFormatter::class);

        return new CreateUserHandler($action, $formatter);
    }
}