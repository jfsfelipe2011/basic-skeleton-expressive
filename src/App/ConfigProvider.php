<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies()
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                // Configurations
                Database\DBALConnection::class             => Database\Factory\DBALConnectionFactory::class,

                // Repositories
                Repository\UserRepository::class           => Repository\Factory\UserRepositoryFactory::class,

                // Formatters
                Formatter\User\GetAllUsersFormatter::class       => Formatter\User\Factory\GetAllUsersFormatterFactory::class,
                Formatter\Validation\ErrorArrayFormatter::class  => Formatter\Validation\Factory\ErrorArrayFormatterFactory::class,
                Formatter\Validation\ErrorStringFormatter::class => Formatter\Validation\Factory\ErrorStringFormatterFactory::class,

                // Actions
                Action\User\GetAllUsersAction::class       => Action\User\Factory\GetAllUsersActionFactory::class,
                Action\User\GetUserAction::class           => Action\User\Factory\GetUserActionFactory::class,
                Action\User\AddUserAction::class           => Action\User\Factory\AddUserActionFactory::class,
                Action\User\AlterUserAction::class         => Action\User\Factory\AlterUserActionFactory::class,

                // Handlers
                Handler\User\ListUsersHandler::class       => Handler\User\Factory\ListUsersHandlerFactory::class,
                Handler\User\ShowUserHandler::class        => Handler\User\Factory\ShowUserHandlerFactory::class,
                Handler\User\CreateUserHandler::class      => Handler\User\Factory\CreateUserHandlerFactory::class,
                Handler\User\UpdateUserHandler::class      => Handler\User\Factory\UpdateUserHandlerFactory::class
            ],
        ];
    }
}
