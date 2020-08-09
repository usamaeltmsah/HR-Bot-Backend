<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Admin;
use App\Applicant;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker){
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Hash::make('12345678'),
        'role' => $faker->randomNumber() % 2 == 0 ? 'recruiter' : 'applicant',
    ];
});

$factory->define(Applicant::class, function (Faker $faker){
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Hash::make('12345678'),
        'role' => 'applicant',
    ];
});

$factory->define(Recruiter::class, function (Faker $faker){
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Hash::make('12345678'),
        'role' => 'recruiter',
    ];
});

$factory->define(Admin::class, function (Faker $faker){
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Hash::make('12345678'),
        'role' => 'admin',
    ];
});