<?php

namespace App\Action\User\Factory;

use App\Action\User\GetAllUsersAction;
use App\Formatter\User\GetAllUsersFormatter;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class GetAllUsersActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $formatter  = $container->get(GetAllUsersFormatter::class);
        $repository = $container->get(UserRepository::class);

        $action = new GetAllUsersAction($formatter, $repository);

        return $action;
    }
}