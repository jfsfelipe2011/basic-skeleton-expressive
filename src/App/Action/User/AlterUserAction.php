<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Filter\UserFilter;
use App\Formatter\Validation\ErrorStringFormatter;
use App\Repository\UserRepository;

class AlterUserAction
{
    /** @var UserRepository */
    private $repository;

    /** @var UserFilter */
    private $filter;

    /** @var ErrorStringFormatter */
    private $formatter;

    /**
     * AlterUserAction constructor.
     *
     * @param UserRepository $repository
     * @param UserFilter $filter
     * @param ErrorStringFormatter $formatter
     */
    public function __construct(UserRepository $repository, UserFilter $filter, ErrorStringFormatter $formatter)
    {
        $this->repository = $repository;
        $this->filter     = $filter;
        $this->formatter  = $formatter;
    }

    /**
     * Ação que faz a alteração de um usuário
     *
     * @param int $id
     * @param array $data
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function action(int $id, array $data): array
    {
        if (!$this->repository->find($id)) {
            throw new \Exception('Usuário não encontrado');
        }

        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->filter->setData($data);

        if (!$this->filter->isValid()) {
            $messages = $this->formatter->format($this->filter->getMessages());

            throw new \InvalidArgumentException($messages);
        }

        $data = $this->filter->getValues();
        $data['password'] = md5($data['password']);
        unset($data['created_at']);

        $user = $this->repository->update($id, $data);

        if (!$user) {
            throw new \RuntimeException('Erro ao alterar usuário');
        }

        return $user;
    }
}