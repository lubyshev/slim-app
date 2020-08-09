<?php
declare(strict_types=1);

namespace App\V1\Models;

use App\Models\SettingsModelInterface;

class SettingsModel implements SettingsModelInterface
{
    protected string $apiKey;

    protected array $apiClients;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $keyPrefix        = strtoupper($this->getVersion());
        $this->apiKey     = (string)env($keyPrefix.'_API_KEY');
        $this->apiClients = [];
        $clients          = explode(',', env($keyPrefix.'_API_CLIENTS'));
        foreach ($clients as $client) {
            [$name, $key] = explode('=', $client);
            $name = trim($name);
            if (!empty($name)) {
                $key = strtoupper(trim($key));
                $this->apiClients[$name]
                     = (string)env($keyPrefix.'_'.$key.'_SECRET');
                if (empty($this->apiClients[$name])) {
                    unset($this->apiClients[$name]);
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @inheritDoc
     */
    public function getSecrets(): array
    {
        return $this->apiClients;
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return 'v1';
    }

}
