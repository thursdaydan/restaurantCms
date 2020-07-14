<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Page::class, static function (Faker $faker) {
    return [
        '' => $faker->words(2, true),
    ];
});
