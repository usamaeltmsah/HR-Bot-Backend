<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->sentences(4, True),
        'accept_interviews_from' => now()->format('Y-m-d H:i:s'),
        'accept_interviews_until'=> $faker->dateTimeBetween('now', '+30 years')->format('Y-m-d H:i:s'),
        'interview_duration' => $faker->randomNumber(4),
        'recruiter_id' => 1
    ];
});
