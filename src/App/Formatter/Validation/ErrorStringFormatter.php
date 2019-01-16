<?php

declare(strict_types=1);

namespace App\Formatter\Validation;

use App\Formatter\FormatterInterface;

class ErrorStringFormatter implements FormatterInterface
{
    /**
     * Retonar as mensagens de erro no formato de string
     *
     * @param $data
     * @return bool|string
     */
    public function format($data): string
    {
        $stringErros = '';

        foreach ($data as $field => $validator) {
            foreach ($validator as $erro) {
                $stringErros .= $field . '-' .$erro . ',';
            }
        }

        return substr($stringErros, 0, -1);
    }
}