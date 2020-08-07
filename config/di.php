<?php
declare(strict_types=1);

use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

$container = [];

$container['db'] = function (Container $container) {
    $capsule = new Capsule;
    $capsule->addConnection(require 'db.php');
    $capsule->bootEloquent();
    $capsule->setAsGlobal();

    return $capsule;
};

return $container;
