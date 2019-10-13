<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/Database/database.php';

$request = Request::createFromGlobals();

$routes = include __DIR__.'/'.APP_BASE.'/routes.php';

$diContainer =  include __DIR__.'/'.APP_BASE.'/di.php';

$response = $diContainer->get('cosy.kernel')->handle($request);

$response->send();