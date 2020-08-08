<?php
declare(strict_types=1);

namespace App\V1\Models;

use App\Models\SettingsModelInterface;

class SettingsModel implements SettingsModelInterface
{
    const CLIENT_SPEED_TEST = 'speedTest';

    private string $apiKey;

    private array $apiClients;

    public function __construct()
    {
        $keyPrefix        = strtoupper($this->getVersion());
        $this->apiKey     = (string)env($keyPrefix.'_API_KEY');
        $this->apiClients = [
            self::CLIENT_SPEED_TEST => (string)env($keyPrefix.'_SPEED_TEST_SECRET'),
        ];
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return array
     */
    public function getSecrets(): array
    {
        return $this->apiClients;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return 'v1';
    }

}