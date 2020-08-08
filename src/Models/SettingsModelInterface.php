<?php
declare(strict_types=1);

namespace App\Models;

interface SettingsModelInterface
{
    /**
     * Init class.
     */
    public function init(): void;

    /**
     * Returns Api-key of service.
     *
     * @return string
     */
    public function getApiKey(): string;

    /**
     * Returns Secret-keys for all service clients.
     *
     * @return array
     */
    public function getSecrets(): array;

    /**
     * Returns current version.
     *
     * @return string
     */
    public function getVersion(): string;

}
