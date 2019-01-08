<?php

namespace App\Formatter\User;

use User\Entity\User;

class GetAllUsersFormatter
{
    /**
     * Formata os usuários como array
     *
     * @param array $users
     * @return array
     */
    public function __invoke(array $users)
    {
        $formatted = array();

        foreach ($users as $user)
        {
            if (!$user instanceof User) {
                continue;
            }

            array_push($formatted, $user->toArray());
        }

        return $formatted;
    }
}