<?php
declare(strict_types=1);

namespace App\DI;

use DI\Container;

class DIContainer
{
    private Container $container;

    public function __construct(array $config)
    {
        $this->container = new Container();
        foreach ($config as $name => $callback) {
            $this->container->set($name, $callback);
        }
    }

    public function getDi(): Container
    {
        return $this->container;
    }

}
