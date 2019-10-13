<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/database.php';

$database = Capsule::connection();
$database->delete('DROP TABLE IF EXISTS vouchers');
$database->delete('DROP TABLE IF EXISTS recipients');
$database->delete('DROP TABLE IF EXISTS special_offers');

//Create Vouchers Table
Capsule::schema()->create('vouchers', function ($table) {
    $table->increments('id');
    $table->string('code', 8)->unique();
    $table->integer('offer_id');
    $table->integer('recipient_id');
    $table->smallInteger('is_used')->default(0);
    $table->date('expire_date');
    $table->dateTime('date_used')->nullable()->default(NULL);
    $table->timestamps();
});

echo 'Vouchers  Table created successfully!'.PHP_EOL;

//Create Recipient Table
Capsule::schema()->create('recipients', function ($table) {
    $table->increments('id');
    $table->string('name', 100);
    $table->string('email', 64)->unique();
    $table->timestamps();
});

echo 'Recipients  Table created successfully!'.PHP_EOL;

//Create Recipient Table
Capsule::schema()->create('special_offers', function ($table) {
    $table->increments('id');
    $table->string('name', 100);
    $table->float('discount_percentage', 64);
    $table->timestamps();
});

echo 'Special Offers  Table created successfully!'.PHP_EOL;

//Create Recipient Table
Capsule::schema()->create('offer_recipients', function ($table) {
    $table->integer('offer_id');
    $table->integer('recipient_id');
});

echo 'Special Offers  Table created successfully!'.PHP_EOL;