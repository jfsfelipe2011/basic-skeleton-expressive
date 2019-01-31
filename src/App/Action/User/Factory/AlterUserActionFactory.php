<?php

declare(strict_types=1);

namespace App\Action\User\Factory;

use App\Action\User\AlterUserAction;
use App\Filter\UserFilter;
use App\Formatter\Validation\ErrorStringFormatter;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class AlterUserActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return AlterUserAction
     */
    public function __invoke(ContainerInterface $container): AlterUserAction
    {
        $filters = $container->get('InputFilterManager');

        $repository = $container->get(UserRepository::class);
        $formatter  = $container->get(ErrorStringFormatter::class);
        $filter     = $filters->get(UserFilter::class);

        return new AlterUserAction($repository, $filter, $formatter);
    }
}