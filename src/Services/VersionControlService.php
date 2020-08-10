<?php
declare(strict_types=1);

namespace App\Services;

use Fig\Http\Message\StatusCodeInterface as StatusCodes;
use Psr\Http\Message\ResponseInterface;

class VersionControlService
{
    private const DEPRECATED_VERSIONS = ['V0'];
    private const ACTUAL_VERSION      = 'V1';
    private const VERSION_ACTIONS     = [
        'V1' => ['Auth', 'Route'],
    ];

    public static function isDeprecated(string $version): bool
    {
        return in_array($version, self::DEPRECATED_VERSIONS);
    }

    public static function isValidAction(string $version, string $action): bool
    {
        return in_array($action, self::VERSION_ACTIONS[$version]);
    }

    public static function renderDeprecatedVersion(
        string $version,
        ResponseInterface $response
    ): ResponseInterface {
        $response->getBody()->write(json_encode([
            'success'       => false,
            'version'       => strtolower($version),
            'actualVersion' => strtolower(self::ACTUAL_VERSION),
            'error'         => [
                'code'    => StatusCodes::STATUS_GONE,
                'message' => 'Gone.',
            ],
        ]));

        return $response->withStatus(StatusCodes::STATUS_GONE);
    }

    public static function renderInvalidAction(
        string $version,
        ResponseInterface $response
    ): ResponseInterface {
        $response->getBody()->write(json_encode([
            'success' => false,
            'version' => strtolower($version),
            'error'   => [
                'code'    => StatusCodes::STATUS_NOT_FOUND,
                'message' => 'Page not found.',
            ],
        ]));

        return $response->withStatus(StatusCodes::STATUS_NOT_FOUND);
    }

}
