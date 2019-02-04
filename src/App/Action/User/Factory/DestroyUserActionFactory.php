<?php

declare(strict_types=1);

namespace App\Action\User\Factory;

use App\Action\User\DestroyUserAction;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class DestroyUserActionFactory
{
    /**
     * Cria uma nova ação de deleção de usuário
     *
     * @param ContainerInterface $container
     * @return DestroyUserAction
     */
    public function __invoke(ContainerInterface $container): DestroyUserAction
    {
        $repository = $container->get(UserRepository::class);

        return new DestroyUserAction($repository);
    }
}