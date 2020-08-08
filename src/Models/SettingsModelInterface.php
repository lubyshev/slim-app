<?php
declare(strict_types=1);

namespace App\Models;

interface SettingsModelInterface
{
    /**
     * @return string
     */
    public function getApiKey(): string;

    /**
     * @return array
     */
    public function getSecrets(): array;

    /**
     * @return string
     */
    public function getVersion(): string;

}
