<?php

declare(strict_types=1);

namespace App\Database;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;

class DBALConnection implements ConnectionInterface
{
    /** @var array */
	private $connectionParams;

	/** @var Configuration */
	private $config;

    /**
     * DBALConnection constructor.
     *
     * @param array $connectionParams
     * @param Configuration $config
     */
	public function __construct(array $connectionParams, Configuration $config)
	{
		$this->connectionParams = $connectionParams;
		$this->config = $config;
	}

    /**
     * @return Connection
     * @throws \Doctrine\DBAL\DBALException
     */
	public function getConnection(): Connection
	{
		return DriverManager::getConnection($this->connectionParams, $this->config);
	}
}