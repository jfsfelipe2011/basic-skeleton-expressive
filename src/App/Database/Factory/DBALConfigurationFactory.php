<?php

namespace App\Database\Factory;

use Doctrine\DBAL\Configuration;

class DBALConfigurationFactory
{
    /**
     * Cria uma nova configuração de DBAL
     *
     * @return Configuration
     */
    public function __invoke() : Configuration
    {
        return new Configuration();
    }
}
