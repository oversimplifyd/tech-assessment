<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ .'/../vendor/autoload.php';
require __DIR__ . '/database.php';

$database = Capsule::connection();
$database->delete('DROP TABLE IF EXISTS recipes');
$database->delete('DROP TABLE IF EXISTS recipe_ratings');

//Create Recipe Table
Capsule::schema()->create('recipes', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->integer('prep_time'); //Prep Time in Seconds
    $table->smallInteger('difficulty');
    $table->smallInteger('vegetarian');
    $table->timestamps();
});

echo 'Recipe  Table created successfully!'.PHP_EOL;

Capsule::schema()->create('recipe_ratings', function ($table) {
    $table->increments('id');
    $table->integer('recipe_id');
    $table->smallInteger('rating');
    $table->timestamps();
});

echo 'Ratings Table created successfully!';
