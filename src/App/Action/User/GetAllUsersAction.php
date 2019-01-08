<?php

namespace App\Action\User;

use App\Action\ActionInterface;
use App\Formatter\User\GetAllUsersFormatter;
use App\Repository\UserRepository;

class GetAllUsersAction implements ActionInterface
{
    /** @var UserRepository */
    private $repository;

    /** @var GetAllUsersFormatter */
    private $formatter;

    public function __construct(GetAllUsersFormatter $formatter, UserRepository $repository)
    {
        $this->formatter  = $formatter;
        $this->repository = $repository;
    }

    public function action()
    {
        $users = $this->repository->findAll();

        $format = $this->getFormatter();

        return $format($users);
    }

    public function getFormatter()
    {
        return $this->formatter;
    }
}