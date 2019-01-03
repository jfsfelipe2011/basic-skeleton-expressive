<?php

declare(strict_types=1);

namespace App\Entity;

interface EntityInterface
{
    public function setId(int $id);

    public function getId(): int;

    public function setCreatedAt(string $created_at);

    public function getCreatedAt(): string;

    public function setUpdatedAt(string $updated_at);

    public function getUpdatedAt(): string;

	public function getArrayCopy(): array;

	public function exchangeArray(array $data);
}