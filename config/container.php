<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Application;

$container = [
    'settings' => function () {
        return require __DIR__.'/settings.php';
    },

    'db' => function () {
        $capsule = new Capsule;
        $capsule->addConnection(require __DIR__.'/db.php');
        $capsule->bootEloquent();
        $capsule->setAsGlobal();

        return $capsule;
    },

];

// Только для WEB
if ('cli' !== php_sapi_name()) {
    $container[App::class]             =
        function (ContainerInterface $container) {
            AppFactory::setContainer($container);

            return AppFactory::create();
        };
    $container[ErrorMiddleware::class] =
        function (ContainerInterface $container) {
            $app      = $container->get(App::class);
            $settings = $container->get('settings')['error'];

            return new ErrorMiddleware(
                $app->getCallableResolver(),
                $app->getResponseFactory(),
                (bool)$settings['display_error_details'],
                (bool)$settings['log_errors'],
                (bool)$settings['log_error_details']
            );
        };
} else // Для консоли
{
    $container['console'] =
        function (ContainerInterface $container) {
            $app      = new Application();
            $commands = scandir($container->get('settings')['src'].'/Commands');
            foreach ($commands as $command) {
                if (in_array($command, ['.', '..'])) {
                    continue;
                }
                $class = sprintf(
                    '\App\Commands\%s',
                    preg_replace('~(.*?)\.php$~i', '$1', $command)
                );
                if (class_exists($class)) {
                    $app->add(new $class);
                };
            }

            return $app;
        };
}

return $container;
