<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Repository\UserRepository;

class GetUserAction
{
    /** @var UserRepository */
    private $repository;

    /**
     * GetUserAction constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Executa a ação de consulta de um registro
     *
     * @param int $id
     * @return mixed
     */
    public function action(int $id)
    {
        $user = $this->repository->find($id);

        return $user->getArrayCopy();
    }
}