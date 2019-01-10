<?php

declare(strict_types=1);

namespace App\Formatter\User\Factory;

use App\Formatter\User\GetAllUsersFormatter;
use Psr\Container\ContainerInterface;

class GetAllUsersFormatterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetAllUsersFormatter();
    }
}
