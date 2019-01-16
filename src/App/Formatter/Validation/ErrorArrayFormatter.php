<?php

declare(strict_types=1);

namespace App\Formatter\Validation;

use App\Formatter\FormatterInterface;

class ErrorArrayFormatter implements FormatterInterface
{

    public function format($data): array
    {
        $mensages = array();

        foreach (explode(',', $data) as $key => $message) {
            $arrayMessage = explode('-', $message);

            $mensages['errors'][$arrayMessage[0]][] = $arrayMessage[1];
        }

        return $mensages;
    }
}