<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) use($x){
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Hash::make('12345678'),
        'role' => $faker->randomNumber() % 2 == 0 ? 'recruiter' : 'applicant',
    ];
});
