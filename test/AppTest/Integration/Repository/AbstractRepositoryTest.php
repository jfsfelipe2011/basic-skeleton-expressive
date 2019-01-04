<?php

declare(strict_types=1);

namespace AppTest\Integration\Repository;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;

class AbstractRepositoryTest extends TestCase
{
    /** @var Connection */
    protected $connection;

    protected function setUp()
    {
        $connectionParams = [
            'driver'   => getenv('MYSQL_DRIVER'),
            'host'      => getenv('MYSQL_HOST'),
            'dbname'      => getenv('MYSQL_DATABASE'),
            'user'      => getenv('MYSQL_USER'),
            'password'      => getenv('MYSQL_PASSWORD')
        ];

        $config = new Configuration();

        $this->connection = DriverManager::getConnection($connectionParams, $config);
    }
}