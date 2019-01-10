<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\DBAL\Connection;

class UserRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     *
     * @param string $primaryKey
     * @param string $table
     * @param string $entity
     * @param Connection $connection
     */
    public function __construct(string $primaryKey, string $table, string $entity, Connection $connection)
    {
        parent::__construct($primaryKey, $table, $entity, $connection);
    }
}
