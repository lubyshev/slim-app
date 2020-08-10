<?php
declare(strict_types=1);

namespace App\Services;

use Psr\Http\Message\ResponseInterface;

class VersionControlService
{
    private const DEPRECATED_VERSIONS = [];
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
    ): ResponseInterface
    {
        $response->getBody()->write(json_encode([
            'success'       => false,
            'version'       => strtolower($version),
            'actualVersion' => strtolower(self::ACTUAL_VERSION),
            'error'         => [
                'code'    => 410,
                'message' => 'Gone.',
            ],
        ]));

        return $response->withStatus(410);
    }

    public static function renderInvalidAction(
        string $version,
        ResponseInterface $response
    ): ResponseInterface
    {
        $response->getBody()->write(json_encode([
            'success'       => false,
            'version'       => strtolower($version),
            'actualVersion' => strtolower(self::ACTUAL_VERSION),
            'error'         => [
                'code'    => 404,
                'message' => 'Not found.',
            ],
        ]));

        return $response->withStatus(404);
    }

}
