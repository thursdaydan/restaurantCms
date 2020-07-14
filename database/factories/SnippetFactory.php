<?php

/** @var Factory $factory */

use App\Snippet;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Snippet::class, static function (Faker $faker) {
    return [
        '' => $faker->words(2, true),
    ];
});
