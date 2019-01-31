<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use App\Action\User\AlterUserAction;
use App\Formatter\Validation\ErrorArrayFormatter;
use App\Handler\User\UpdateUserHandler;
use Psr\Container\ContainerInterface;

class UpdateUserHandlerFactory
{
    /**
     * Cria um novo handler de Update
     *
     * @param ContainerInterface $container
     * @return UpdateUserHandler
     */
    public function __invoke(ContainerInterface $container): UpdateUserHandler
    {
        $action    = $container->get(AlterUserAction::class);
        $formatter = $container->get(ErrorArrayFormatter::class);

        return new UpdateUserHandler($action, $formatter);
    }
}