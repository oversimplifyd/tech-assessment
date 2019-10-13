<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$config = include __DIR__ . '/../config.php';

$capsule = new Capsule();

$capsule->addConnection($config['database']);

$capsule->setAsGlobal();

$capsule->bootEloquent();
