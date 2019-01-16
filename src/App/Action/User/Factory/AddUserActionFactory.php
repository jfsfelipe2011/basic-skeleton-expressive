<?php

declare(strict_types=1);

namespace App\Action\User\Factory;

use App\Action\User\AddUserAction;
use App\Filter\UserFilter;
use App\Formatter\Validation\ErrorStringFormatter;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class AddUserActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return AddUserAction
     */
    public function __invoke(ContainerInterface $container): AddUserAction
    {
        $filters = $container->get('InputFilterManager');

        $repository = $container->get(UserRepository::class);
        $formatter  = $container->get(ErrorStringFormatter::class);
        $filter     = $filters->get(UserFilter::class);

        return new AddUserAction($repository, $filter, $formatter);
    }
}