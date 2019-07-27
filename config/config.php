<?php

declare(strict_types=1);

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => getenv('CACHE_PATH'),
];

$aggregator = new ConfigAggregator([
    \Zend\Filter\ConfigProvider::class,
    \Zend\Validator\ConfigProvider::class,
    \Zend\Expressive\Router\FastRouteRouter\ConfigProvider::class,
    \Zend\HttpHandlerRunner\ConfigProvider::class,
    \Zend\InputFilter\ConfigProvider::class,
    // Include cache configuration
    new ArrayProvider($cacheConfig),

    \Zend\Expressive\Helper\ConfigProvider::class,
    \Zend\Expressive\ConfigProvider::class,
    \Zend\Expressive\Router\ConfigProvider::class,

    // Swoole config to overwrite some services (if installed)
    class_exists(\Zend\Expressive\Swoole\ConfigProvider::class)
        ? \Zend\Expressive\Swoole\ConfigProvider::class
        : function(){ return[]; },

    // Default App module config
    App\ConfigProvider::class,

    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php')

], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
