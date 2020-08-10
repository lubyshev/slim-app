<?php
declare(strict_types=1);

use App\Services\VersionControlService as VersionControl;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
    $app->post(
        '/api/{version:v1|v2}/{action:auth|route}',
        function (
            ServerRequestInterface $request,
            ResponseInterface $response,
            array $args
        ) use ($app) {
            $version    = strtoupper($args['version']);
            $actionName = ucfirst($args['action']);
            if (VersionControl::isDeprecated($version)) {
                $response = VersionControl::renderDeprecatedVersion($version, $response);
            } elseif (!VersionControl::isValidAction($version, $actionName)) {
                $response = VersionControl::renderInvalidAction($version, $response);
            } else {
                $actionClass   = sprintf(
                    '\App\%s\Controllers\%sAction',
                    $version, $actionName
                );
                $settingsClass = sprintf(
                    '\App\%s\Models\SettingsModel',
                    $version
                );

                $settings = new $settingsClass();
                $settings->init();

                /** @var \App\Controllers\ActionAbstract $action */
                $action   = new $actionClass($app, $settings);
                $response = $action->beforeAction($request, $response);
                if (200 === $response->getStatusCode()) {
                    $response = ($action)($request, $response);
                }
            }

            return $response->withHeader('Content-Type', 'application/json');
        });
};
