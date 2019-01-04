<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\DBAL\Connection;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var int
     */
    protected $affectedRows = 0;

    /**
     * AbstractRepository constructor.
     *
     * @param int $primaryKey
     * @param string $table
     */
    public function __construct(string $primaryKey, string $table, string $entity, Connection $connection)
    {
        $this->primaryKey = $primaryKey;
        $this->table      = $table;
        $this->connection = $connection;
        $this->entity     = $entity;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @return int
     */
    public function getAffectedRows(): int
    {
        return $this->affectedRows;
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findAll(int $limit = null, int $offset = null): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('*')
                     ->from($this->getTable());

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        $stmt = $queryBuilder->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $entities = array();

        foreach ($result as $data) {
            $mappedEntity = new $this->entity;
            $mappedEntity->exchangeArray($data);

            array_push($entities, $mappedEntity);
        }

        return $entities;
    }
}