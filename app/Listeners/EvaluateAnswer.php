<?php

namespace App\Listeners;

use App\Events\AnswerCreated;
use App\Services\AnswerEvaluator;

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
        $evaluator = new AnswerEvaluator();
        $answer = $event->answer->body;
        $modelAnswers = $event->answer->question->modelAnswers->pluck('body')->toArray();
        $score = $evaluator->evaluate($answer, $modelAnswers);
        $event->answer->fill(['score' => $score])->save();
    }
}