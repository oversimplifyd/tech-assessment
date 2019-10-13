<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('base', new Routing\Route(
    '/',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RecipeController(), 'index')),
    [],
    [],
    '',
    [],
    ['GET']
));

$routes->add('recipe_index', new Routing\Route(
    '/recipes',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RecipeController(), 'index')),
    [],
    [],
    '',
    [],
    ['GET']
));

$routes->add('recipe_create', new Routing\Route(
    '/recipes',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RecipeController(), 'create')),
    [],
    [],
    '',
    [],
    ['POST']
));

$routes->add('recipe_update', new Routing\Route(
    '/recipes/{recipeId}',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RecipeController(), 'update')),
    ['recipeId' => '\d+'],
    [],
    '',
    [],
    ['PUT']
));

$routes->add('recipe_search', new Routing\Route(
    '/recipes/search',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RecipeController(), 'search')),
    [],
    [],
    '',
    [],
    ['GET']
));

$routes->add('recipe_delete', new Routing\Route(
    '/recipes/{recipeId}',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RecipeController(), 'delete')),
    ['recipeId' => '\d+'],
    [],
    '',
    [],
    ['DELETE']
));

$routes->add('recipe_rate', new Routing\Route(
    '/recipes/{recipeId}/rating',
    array('_controller' => array(new \HelloFresh\Recipe\Controller\RatingController(), 'rate')),
    ['recipeId' => '\d+'],
    [],
    '',
    [],
    ['POST']
));

return $routes;
