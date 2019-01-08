<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Formatter\User\GetAllUsersFormatter;
use App\Repository\UserRepository;

class GetAllUsersAction
{
    /** @var UserRepository */
    private $repository;

    /** @var GetAllUsersFormatter */
    private $formatter;

    /**
     * GetAllUsersAction constructor.
     *
     * @param GetAllUsersFormatter $formatter
     * @param UserRepository $repository
     */
    public function __construct(GetAllUsersFormatter $formatter, UserRepository $repository)
    {
        $this->formatter  = $formatter;
        $this->repository = $repository;
    }

    /**
     * Executa a ação de consulta de todos os usuários
     * ou uma parte
     *
     * @return array
     */
    public function action(int $limit, int $offset)
    {
        $users = $this->repository->findAll($limit, $offset);

        $format = $this->getFormatter();

        return $format($users);
    }

    /**
     * Retorna o formatador da classe
     *
     * @return GetAllUsersFormatter
     */
    private function getFormatter()
    {
        return $this->formatter;
    }
}