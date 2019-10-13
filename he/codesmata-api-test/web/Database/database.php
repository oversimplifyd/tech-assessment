<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$config = include __DIR__.'/../src/config.php';

$capsule = new Capsule();

$capsule->addConnection($config['database']);

$capsule->setAsGlobal();

$capsule->bootEloquent();
