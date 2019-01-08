<?php

declare(strict_types=1);

namespace App\Action;

interface ActionInterface
{
    /** Método que executa a ação */
    public function action();
}