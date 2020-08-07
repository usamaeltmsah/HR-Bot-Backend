<?php

use App\Job;
use App\User;
use App\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create();
    	$jobs = factory(Job::class, 10)->create();

        foreach ($jobs as $job) {
        	$questions = factory(Question::class, 5)->create();
        	$job->questions()
        			->attach($questions);
        }
    }
}
