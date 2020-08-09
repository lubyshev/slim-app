<?php
declare(strict_types=1);

namespace App\V1\Controllers;

use App\Controllers\ActionAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteAction extends ActionAbstract
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $params = $request->getParsedBody();
        $response->getBody()->write(json_encode($params));
        $code = 200;

        return $response->withStatus($code);
    }

    protected function validateParams(ServerRequestInterface $request): bool
    {
        return true;
    }
}
