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
    public function create(array $data, array $types);
}
