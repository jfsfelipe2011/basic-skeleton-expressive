<?php

declare(strict_types=1);

namespace App\Formatter\Validation\Factory;

use App\Formatter\Validation\ErrorStringFormatter;
use Psr\Container\ContainerInterface;

class ErrorStringFormatterFactory
{
    /**
     * @param ContainerInterface $container
     * @return ErrorStringFormatter
     */
    public function __invoke(ContainerInterface $container): ErrorStringFormatter
    {
        return new ErrorStringFormatter();
    }
}