<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Repository\UserRepository;

class DestroyUserAction
{
    /** @var UserRepository */
    private $repository;

    /**
     * DestroyUserAction constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Executa a ação de deletar um usuário
     *
     * @param int $id
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Exception
     */
    public function execute(int $id)
    {
        if (!$this->repository->find($id)) {
            throw new \Exception('Usuário não encontrado');
        }

        $delete = $this->repository->delete($id);

        if (!$delete) {
            return false;
        }

        return true;
    }
}