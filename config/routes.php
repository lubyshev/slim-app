<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hello, Kitty!');

        return $response;
    });

    $app->group('/api', function () use ($app) {
        $app->group('/api/v1', function () use ($app) {
            $app->post('/api/v1/auth', \App\V1\Controllers\AuthAction::class);
            $app->get('/route/list', 'App\V1\Controllers\RouteController:get');
            $app->post('/route/{id:\d+}', 'App\V1\Controllers\RouteController:post');
        });
        $app->group('/api/v2', function () use ($app) {
            $app->post('/api/v2/auth', \App\V2\Controllers\AuthAction::class);
        });
    });
};
