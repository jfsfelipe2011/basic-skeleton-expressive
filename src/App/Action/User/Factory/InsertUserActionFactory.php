<?php

declare(strict_types=1);

namespace App\Action\User\Factory;

use App\Action\User\InsertUserAction;
use App\Filter\UserFilter;
use App\Formatter\Validation\ErrorStringFormatter;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class InsertUserActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return InsertUserAction
     */
    public function __invoke(ContainerInterface $container): InsertUserAction
    {
        $filters = $container->get('InputFilterManager');

        $repository = $container->get(UserRepository::class);
        $formatter  = $container->get(ErrorStringFormatter::class);
        $filter     = $filters->get(UserFilter::class);

        return new InsertUserAction($repository, $filter, $formatter);
    }
}