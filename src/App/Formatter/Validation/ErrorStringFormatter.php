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

        if (!is_array($data)) {
            return $stringErros;
        }

        foreach ($data as $field => $validator) {
            if (!is_array($validator)) {
                continue;
            }

            foreach ($validator as $erro) {
                $stringErros .= $field . '-' .$erro . ',';
            }
        }

        if (empty($stringErros)) {
            return $stringErros;
        }

        return substr($stringErros, 0, -1);
    }
}