<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__.'/../vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");

    return $response;
});

$app->run();
