<?php

declare(strict_types=1);

namespace App\Formatter\Validation\Factory;

use App\Formatter\Validation\ErrorArrayFormatter;
use Psr\Container\ContainerInterface;

class ErrorArrayFormatterFactory
{
    /**
     * @param ContainerInterface $container
     * @return ErrorArrayFormatter
     */
    public function __invoke(ContainerInterface $container): ErrorArrayFormatter
    {
        return new ErrorArrayFormatter();
    }
}