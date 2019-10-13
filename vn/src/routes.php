<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('home', new Routing\Route(
    '/',
    array('_controller' => 'Vanhack\Voucher\Controller\VoucherController::indexAction'),
    [],
    [],
    '',
    [],
    ['GET']
));

$routes->add('voucher-generate', new Routing\Route(
    '/voucher/generate/{offer_id}/{expire_date}',
    array('_controller' => 'Vanhack\Voucher\Controller\VoucherController::generateAction'),
    ['offer_id' => '\d+'],
    [],
    '',
    [],
    ['GET']
));

$routes->add('vouchers', new Routing\Route(
    '/voucher/{email}',
    array('_controller' => 'Vanhack\Voucher\Controller\VoucherController::getVouchers'),
    [],
    [],
    '',
    [],
    ['GET']
));

$routes->add('vouchers', new Routing\Route(
    '/voucher/verify/{code}',
    array('_controller' => 'Vanhack\Voucher\Controller\VoucherController::verifyVoucher'),
    [],
    [],
    '',
    [],
    ['GET']
));

$routes->add('create-offer-recipient', new Routing\Route(
    '/offers/{offerId}/recipient',
    array('_controller' => 'Vanhack\Voucher\Controller\OfferController::createRecipientsAction'),
    ['offerId' => '\d+'],
    [],
    '',
    [],
    ['POST']
));

$routes->add('create-offer', new Routing\Route(
    '/offers',
    array('_controller' => 'Vanhack\Voucher\Controller\OfferController::createAction'),
    [],
    [],
    '',
    [],
    ['POST']
));

$routes->add('create-recipient', new Routing\Route(
    '/recipients',
    array('_controller' => 'Vanhack\Voucher\Controller\RecipientController::createAction'),
    [],
    [],
    '',
    [],
    ['POST']
));

return $routes;
