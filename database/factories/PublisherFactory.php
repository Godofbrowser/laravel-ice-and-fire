<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Publisher::class, function (Faker $faker) {
    return [
		'name' => $faker->name
    ];
});
