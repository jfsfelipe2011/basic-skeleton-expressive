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
     * retorna o nome da tabela do repositorio
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Retorna o nome do campo chave primaria
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * retorna a quandidade de linha afetadas
     *
     * @return int
     */
    public function getAffectedRows(): int
    {
        return $this->affectedRows;
    }

    /**
     * Busca todos os registros, pode ser página pelos parametros
     * limit que é a quantidade de registros de retorno ou offset
     * que é o registro de inicio da busca
     *
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findAll(int $limit = null, int $offset = null): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('*')
                     ->from($this->getTable());

        // caso tenha sido passado o parametro limit, ele seta a quantidade
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        // caso tenha sido passdo o parametro offset, ele seta o primeiro registro
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        $stmt = $queryBuilder->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $entities = [];

        // transforma os resultados em entidades
        foreach ($result as $data) {
            $mappedEntity = new $this->entity;
            $mappedEntity->exchangeArray($data);

            array_push($entities, $mappedEntity);
        }

        return $entities;
    }
}
