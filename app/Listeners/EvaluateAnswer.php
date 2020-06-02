<?php

namespace App\Listeners;

use App\Events\AnswerCreated;
use App\Http\Controllers\AnswerController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EvaluateAnswer implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    function handle($event)
    {
        // strings
        // $question = $event->newAnswer->question->body;
        $answer = $event->newAnswer->body;

        // float
        $score = AnswerController::evalAnswer($answer);
        
        // $event->newAnswer->score = $score;
        // $event->newAnswer->save();
        // $event->newAnswer->fill(['score' => $score])->save();
        $event->newAnswer->update(['score' => $score]);
    }
}