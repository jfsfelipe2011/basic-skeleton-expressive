<?php

declare(strict_types=1);

namespace App\Formatter\User;

use App\Entity\UserEntity;
use App\Formatter\FormatterInterface;

class GetAllUsersFormatter implements FormatterInterface
{
    /**
     * Formata os usuários como array
     *
     * @param array $users
     * @return array
     */
    public function format($data): array
    {
        $formatted = [];

        foreach ($data as $user) {
            if (!$user instanceof UserEntity) {
                continue;
            }

            array_push($formatted, $user->getArrayCopy());
        }

        return $formatted;
    }
}
