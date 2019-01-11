<?php

declare(strict_types=1);

namespace App\Action\User\Factory;

use App\Action\User\GetUserAction;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class GetUserActionFactory
{
    /**
     * Cria um nova ação de consulta de usuário
     *
     * @param ContainerInterface $container
     * @return GetUserAction
     */
    public function __invoke(ContainerInterface $container): GetUserAction
    {
        $repository = $container->get(UserRepository::class);

        $action = new GetUserAction($repository);

        return $action;
    }
}