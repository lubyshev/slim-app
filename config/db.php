<?php

return [
    'driver'   => 'pgsql',
    'host'     => env('DB_HOST'),
    'port'     => (int)env('DB_PORT'),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset'  => 'utf8',
    'prefix'   => env('DB_PREFIX'),
    'schema'   => env('DB_SCHEMA'),
];
