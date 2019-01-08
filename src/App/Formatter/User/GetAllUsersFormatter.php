<?php

namespace App\Formatter\User;


use App\Entity\UserEntity;

class GetAllUsersFormatter
{
    /**
     * Formata os usuários como array
     *
     * @param array $users
     * @return array
     */
    public function __invoke(array $users): array
    {
        $formatted = array();

        foreach ($users as $user)
        {
            if (!$user instanceof UserEntity) {
                continue;
            }

            array_push($formatted, $user->getArrayCopy());
        }

        return $formatted;
    }
}