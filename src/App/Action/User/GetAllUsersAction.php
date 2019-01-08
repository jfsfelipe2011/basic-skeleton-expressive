<?php

namespace App\Action\User;

use App\Formatter\User\GetAllUsersFormatter;

class GetAllUsersAction
{
    /** @var GetAllUsersFormatter */
    private $formatter;

    public function __construct(GetAllUsersFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function action()
    {

    }
}