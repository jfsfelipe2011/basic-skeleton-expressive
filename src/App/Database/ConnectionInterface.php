<?php

declare(strict_types=1);

namespace App\Database;

interface ConnectionInterface
{
    /** Método que deve retornar a conexão com a base de dados */
	public function getConnection();
}