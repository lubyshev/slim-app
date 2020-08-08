<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\SettingsModelInterface;
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

}
