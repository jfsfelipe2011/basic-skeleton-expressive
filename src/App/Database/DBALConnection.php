<?php

namespace App\Database;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class DBALConnection implements ConnectionInterface
{
	private $connectionParams;

	private $config;

	public function __construct(array $connectionParams, Configuration $config)
	{
		$this->connectionParams = $connectionParams;
		$this->config = $config;
	}

	public function getConnection()
	{
		return DriverManager::getConnection($this->connectionParams, $this->config);
	}
}