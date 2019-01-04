<?php

declare(strict_types=1);

namespace App\Repository;

interface RepositoryInterface
{
    public function getTable(): string;

    public function getPrimaryKey(): string;

    public function getAffectedRows(): int;

    public function findAll(int $limit, int $offset): array;
}