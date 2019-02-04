<?php

declare(strict_types=1);

namespace App\Repository;

interface RepositoryInterface
{
    /** Método que deve retornar todos os registros ou uma parcela */
    public function findAll(int $limit, int $offset): array;

    /** Método que deve retornar um registro */
    public function find(int $id);

    /** Método que deve criar um registro */
    public function insert(array $data, array $types);

    /** Método que deve atualizar um registro */
    public function update(int $id, array $data, array $types);

    /** Método que deve deletar um registro */
    public function delete(int $id);
}
