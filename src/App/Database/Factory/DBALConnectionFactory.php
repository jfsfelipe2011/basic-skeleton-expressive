<?php

namespace App\Database\Factory;

use App\Database\DBALConnection;
use Psr\Container\ContainerInterface;

class DBALConnectionFactory
{
	public function __invoke(ContainerInterface $container)
	{
		$dbal = new DBALConnection($container->get('config')['default_connection'],
			$container->get(\Doctrine\DBAL\Configuration::class));

		return $dbal->getConnection();
	}
}