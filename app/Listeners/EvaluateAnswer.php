<?php

namespace App\Listeners;

use App\Events\AnswerCreated;
use App\Http\Controllers\AnswerController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
class EvaluateAnswer
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    function handle($event)
    {
        AnswerController::sendAnsEvalToDB($event->newAnswer);
    }
}
