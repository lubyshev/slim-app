<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\SettingsModelInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

abstract class ActionAbstract
{
    protected App $app;

    protected SettingsModelInterface $settings;

    public function __construct(App $app, SettingsModelInterface $settings)
    {
        $this->app      = $app;
        $this->settings = $settings;
    }

    public function beforeAction(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        if (!$this->validateParams($request)) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'version' => $this->settings->getVersion(),
                'error'   => [
                    'code'    => 400,
                    'message' => 'Bad request.',
                ],
            ]));

            return $response->withStatus(400);
        }

        return $response;
    }

    abstract protected function validateParams(ServerRequestInterface $request): bool;

}
