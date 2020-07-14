<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Menu;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Menu::class, static function (Faker $faker) {
    return [
        '' => $faker->words(2, true),
    ];
});
