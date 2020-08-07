<?php
declare(strict_types=1);

use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

$container = [];

$container['db'] = function (Container $container) {
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'   => 'pgsql',
        'host'     => env('DB_HOST'),
        'port'     => (int)env('DB_PORT'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset'  => 'utf8',
        'prefix'   => env('DB_PREFIX'),
        'schema'   => env('DB_SCHEMA'),
    ]);

    $capsule->bootEloquent();
    $capsule->setAsGlobal();

    return $capsule;
};

return $container;
