<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\SettingsModelInterface;
use Fig\Http\Message\StatusCodeInterface as StatusCodes;
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
                    'code'    => StatusCodes::STATUS_BAD_REQUEST,
                    'message' => 'Bad request.',
                ],
            ]));
            $response = $response->withStatus(StatusCodes::STATUS_BAD_REQUEST);
        }

        return $response;
    }

    abstract protected function validateParams(ServerRequestInterface $request): bool;

}
