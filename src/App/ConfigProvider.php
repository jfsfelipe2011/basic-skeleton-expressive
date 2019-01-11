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

                // Formatter
                Formatter\User\GetAllUsersFormatter::class => Formatter\User\Factory\GetAllUsersFormatterFactory::class,

                // Actions
                Action\User\GetAllUsersAction::class       => Action\User\Factory\GetAllUsersActionFactory::class,
                Action\User\GetUserAction::class           => Action\User\Factory\GetUserActionFactory::class,

                // Handlers
                Handler\User\ListUsersHandler::class       => Handler\User\Factory\ListUsersHandlerFactory::class,
                Handler\User\ShowUserHandler::class        => Handler\User\Factory\ShowUserHandlerFactory::class
            ],
        ];
    }
}
