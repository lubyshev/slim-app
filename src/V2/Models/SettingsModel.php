<?php
declare(strict_types=1);

namespace App\V2\Models;

class SettingsModel extends \App\V1\Models\SettingsModel
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return 'v2';
    }

}
