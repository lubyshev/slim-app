<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->post('/api/{version:v1|v2}/{action:auth|route}', function (
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ) use ($app) {
        $actionClass   = sprintf(
            '\App\%s\Controllers\%sAction',
            strtoupper($args['version']), ucfirst($args['action'])
        );
        $settingsClass = sprintf(
            '\App\%s\Models\SettingsModel',
            strtoupper($args['version'])
        );

        $settings = new $settingsClass();
        $settings->init();

        return
            (new $actionClass($app, $settings))
            ($request, $response, $args)
                ->withHeader('Content-Type', 'application/json');
    });
};
