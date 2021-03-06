<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'fcm_token' => $faker->uuid,
        'uuid' => $faker->uuid,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Advertisement::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'title' => $faker->title,
        'description' => $faker->text,
        'tags' => str_replace(' ', ',', $faker->words(3, true)),
        'price' => $faker->numberBetween(10,100),
        'price_unit' => $faker->randomElement(['USD', 'BRL']),
        'published_at' => $faker->boolean() ? \Carbon\Carbon::now()->toDateTimeString() : null
    ];
});