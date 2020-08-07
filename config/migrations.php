<?php
require __DIR__.'/../vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

return [
    'paths'                => [
        'migrations' => 'migrations',
    ],
    'migration_base_class' => '\App\Db\Migration',
    'environments'         => [
        'default_migration_table' => 'migrations',
        'default_database'        => 'slimapp',
        'slimapp'                 => [
            'adapter' => 'pgsql',
            'host'    => env('DB_HOST'),
            'name'    => env('DB_DATABASE'),
            'user'    => env('DB_USERNAME'),
            'pass'    => env('DB_PASSWORD'),
            'port'    => (int)env('DB_PORT'),
            'charset' => 'utf8',
        ],
    ],
];
