<?php

declare(strict_types=1);

namespace App\Database\Factory;

use App\Database\DBALConnection;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

class DBALConnectionFactory
{
    /**
     * Cria uma conexão com a base de dados
     *
     * @param ContainerInterface $container
     * @return Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __invoke(ContainerInterface $container): Connection
    {
        $dbal = new DBALConnection(
            $container->get('config')['default_connection'],
            $container->get(\Doctrine\DBAL\Configuration::class)
        );

        return $dbal->getConnection();
    }
}
