<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Illuminate\Database\Capsule\Manager as Capsule;

return [
    'settings' => function () {
        return require __DIR__.'/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app      = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    'db' => function (ContainerInterface $container) {
        $capsule = new Capsule;
        $capsule->addConnection(require 'db.php');
        $capsule->bootEloquent();
        $capsule->setAsGlobal();

        return $capsule;
    },

];
