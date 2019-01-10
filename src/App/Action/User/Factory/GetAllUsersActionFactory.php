<?php

declare(strict_types=1);

namespace App\Action\User\Factory;

use App\Action\User\GetAllUsersAction;
use App\Formatter\User\GetAllUsersFormatter;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class GetAllUsersActionFactory
{
    /**
     * Cria uma nova ação de consulta de todos os registros ou parte
     *
     * @param ContainerInterface $container
     * @return GetAllUsersAction
     */
    public function __invoke(ContainerInterface $container): GetAllUsersAction
    {
        $formatter  = $container->get(GetAllUsersFormatter::class);
        $repository = $container->get(UserRepository::class);

        $action = new GetAllUsersAction($formatter, $repository);

        return $action;
    }
}
