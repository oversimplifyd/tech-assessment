<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/Database/database.php';

$request = Request::createFromGlobals();

$routes = include __DIR__ . '/src/routes.php';

$diContainer = include __DIR__ . '/src/di.php';

try {
    $response = $diContainer->get('cosy.kernel')->handle($request);
    $response->send();
} catch (\Vanhack\Voucher\Controller\HttpExceptions\AbstractHttpException $exception) {

    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->setStatusCode($exception->getCode());
    $response->setContent(json_encode($exception->getAppError()));
    $response->headers->set('Content-Type', 'application/json');

    $response->send();
} catch (\Exception $exception) {
    $result = [
        \Vanhack\Voucher\Controller\HttpExceptions\AbstractHttpException::KEY_CODE => 500,
        \Vanhack\Voucher\Controller\HttpExceptions\AbstractHttpException::KEY_MESSAGE => 'Some error occurred internally.'
    ];

    //TODO:: Log Exception Message here for internal debugging.

    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->setStatusCode(500);
    $response->headers->set('Content-Type', 'application/json');
    $response->setContent(json_encode($result));
    $response->send();
}
