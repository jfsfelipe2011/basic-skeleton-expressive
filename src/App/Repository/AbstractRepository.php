<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

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
     * @return QueryBuilder
     */
    private function getSelectBuilder(): QueryBuilder
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('*')
            ->from($this->getTable());

        return $queryBuilder;
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
        $queryBuilder = $this->getSelectBuilder();

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

    /**
     * Busca o registro tendo em relação a chave primaria
     * da entidade
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $queryBuilder = $this->getSelectBuilder();

        $queryBuilder->where($this->getPrimaryKey() . ' = :id');
        $queryBuilder->setParameter('id', $id);

        $stmt = $queryBuilder->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return false;
        }

        $mappedEntity = new $this->entity;
        $mappedEntity->exchangeArray($data);

        return $mappedEntity;
    }

    /**
     * Insere um novo registro
     *
     * @param array $data
     * @param array $types
     * @return array|bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insert(array $data, array $types = array())
    {
        if (empty($data)) {
            return false;
        }

        $this->affectedRows = $this->connection->insert($this->getTable(), $data, $types);

        if (!$this->affectedRows) {
            return false;
        }

        $entity = new $this->entity;
        $entity->exchangeArray($data);
        $entity = $entity->getArrayCopy();
        $entity['id'] = $this->connection->lastInsertId();

        return $entity;
    }

    /**
     * Atualiza um registro
     *
     * @param int $id
     * @param array $data
     * @param array $types
     * @return array|bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update(int $id, array $data, array $types = array())
    {
        if (empty($data)) {
            return false;
        }

        $this->affectedRows = $this->connection->update($this->getTable(), $data, [
            $this->getPrimaryKey() => $id
        ], $types);

        if (!$this->affectedRows) {
            return false;
        }

        $entity = $this->find($id);

        return $entity->getArrayCopy();
    }

    /**
     * Deleta um registro
     *
     * @param int $id
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete(int $id) : bool
    {
        $this->affectedRows = $this->connection->delete($this->getTable(), [
            $this->getPrimaryKey() => $id
        ]);

        if (!$this->affectedRows) {
            return false;
        }

        return true;
    }

    /**
     * Retorna ultimo id de usuário
     *
     * @return int
     */
    public function getLastUserId(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $stmt = $queryBuilder->select('id')
            ->from($this->getTable())
            ->orderBy('id', 'DESC')
            ->setMaxResults(1)
            ->execute();
        $id = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $id['id'];
    }
}
