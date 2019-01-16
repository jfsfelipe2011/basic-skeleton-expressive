<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Filter\UserFilter;
use App\Formatter\Validation\ErrorStringFormatter;
use App\Repository\UserRepository;

class AddUserAction
{
    /** @var UserRepository */
    private $repository;

    /** @var UserFilter */
    private $filter;

    /** @var ErrorStringFormatter */
    private $formatter;

    /**
     * InsertUserAction constructor.
     *
     * @param UserRepository $repository
     * @param UserFilter $filter
     */
    public function __construct(UserRepository $repository, UserFilter $filter, ErrorStringFormatter $formatter)
    {
        $this->repository = $repository;
        $this->filter     = $filter;
        $this->formatter  = $formatter;
    }

    /**
     * Ação que faz a criação do usuário
     *
     * @param array $data
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function action(array $data): array
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->filter->setData($data);

        if (!$this->filter->isValid()) {
            $messages = $this->formatter->format($this->filter->getMessages());

            throw new \InvalidArgumentException($messages);
        }

        $data = $this->filter->getValues();
        $data['password'] = md5($data['password']);

        $user = $this->repository->insert($data);

        if (!$user) {
            throw new \RuntimeException('Erro ao adicionar usuário');
        }

        return $user;
    }
}