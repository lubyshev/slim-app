<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__.'/../vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__.'/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

// Только для WEB
if ('cli' !== php_sapi_name()) {
    // Register routes
    (require __DIR__.'/routes.php')($app);
    // Register middleware
    (require __DIR__.'/middleware.php')($app);
} else {
    $app = $container;
}

return $app;
