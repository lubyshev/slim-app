<?php
declare(strict_types=1);

namespace App\Services;

use Psr\Http\Message\ResponseInterface;

class VersionControlService
{
    private const DEPRECATED_VERSIONS = [];
    private const ACTUAL_VERSION      = 'V1';

    public static function isDeprecated(string $version): bool
    {
        return in_array($version, self::DEPRECATED_VERSIONS);
    }

    public static function renderDeprecatedVersion(string $version, ResponseInterface $response): ResponseInterface
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

}
