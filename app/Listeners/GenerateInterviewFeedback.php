<?php

namespace App\Listeners;

use App\Services\FeedbackGenerator;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\InterviewStatusBecameNotSelected;

class GenerateInterviewFeedback
{

    /**
     * Handle the event.
     *
     * @param  InterviewStatusBecameNotSelected  $event
     * @return void
     */
    public function handle(InterviewStatusBecameNotSelected $event)
    {
        $interview = $event->interview;
        $skills = $interview->getSkillsNamesNeedImprovement();
        $feedbackGenerator = new FeedbackGenerator();
        $feedback = $feedbackGenerator->generate($skills);
        $interview->feedback= json_encode($feedback);
        $interview->save();
    }
}
