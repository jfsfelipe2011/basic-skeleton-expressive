<?php

namespace App\Database\Factory;

use Doctrine\DBAL\Configuration;

class DBALConfigurationFactory
{
	public function __invoke() : Configuration
	{
		return new Configuration();
	}
}