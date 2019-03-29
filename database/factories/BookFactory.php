<?php

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'isbn' => $faker->unique()->isbn13,
		'country' => $faker->country,
		'number_of_pages' => $faker->numberBetween(200, 500),
		'publisher_id' => function() {
    		return factory(\App\Models\Publisher::class)->create();
		},
		'release_date' => now(),
    ];
});
