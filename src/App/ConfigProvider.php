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
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class                  => Handler\PingHandler::class
            ],
            'factories'  => [
                Handler\HomePageHandler::class             => Handler\HomePageHandlerFactory::class,
                Database\DBALConnection::class             => Database\Factory\DBALConnectionFactory::class,
                Repository\UserRepository::class           => Repository\Factory\UserRepositoryFactory::class,
                Formatter\User\GetAllUsersFormatter::class => Formatter\User\Factory\GetAllUsersFormatterFactory::class,
                Action\User\GetAllUsersAction::class       => Action\User\Factory\GetAllUsersActionFactory::class,
                Handler\User\GetAllUsersHandler::class     => Handler\User\Factory\GetAllUsersHandlerFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
