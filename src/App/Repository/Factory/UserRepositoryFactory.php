<?php

declare(strict_types=1);

namespace App\Repository\Factory;

use App\Database\DBALConnection;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

class UserRepositoryFactory
{
    /** @var string  */
    const PRIMARY_KEY = 'id';

    /** @var string  */
    const TABLE = 'users';

    /** @var string  */
    const ENTITY = UserEntity::class;

    public function __invoke(ContainerInterface $container)
    {
        $connection = $container->get(DBALConnection::class);

        return new UserRepository(self::PRIMARY_KEY, self::TABLE, self::ENTITY, $connection);
    }
}