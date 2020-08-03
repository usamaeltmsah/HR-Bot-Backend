<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'desc' => $faker->sentences(4, True),
        'accept_interviews_from' => $faker->dateTime,
        'accept_interviews_until'=> $faker->dateTime,
        'interview_duration' => $faker->randomNumber(4),
        'recruiter_id' => 1
    ];
});
