<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Listeners\GenerateInterviewFeedback;
use App\Events\InterviewStatusBecameNotSelected;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\AnswerCreated' =>[
            'App\Listeners\EvaluateAnswer'
        ],

        InterviewStatusBecameNotSelected::class => [
            GenerateInterviewFeedback::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
