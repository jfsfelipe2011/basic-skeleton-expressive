<?php

declare(strict_types=1);

namespace App\Formatter\Validation;

use App\Formatter\FormatterInterface;

class ErrorArrayFormatter implements FormatterInterface
{
    /**
     * @param $data
     * @return array
     */
    public function format($data): array
    {
        $messages = array();

        if (!is_string($data)) {
            return $messages;
        }

        $data = explode(',', $data);

        if (empty($data)) {
            return $messages;
        }

        foreach ($data as $key => $message) {
            $arrayMessage = explode('-', $message);

            if (count($arrayMessage) < 2) {
                continue;
            }

            $messages['errors'][$arrayMessage[0]][] = $arrayMessage[1];
        }

        return $messages;
    }
}