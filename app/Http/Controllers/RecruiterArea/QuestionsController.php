<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Skill;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecruiterArea\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionsController extends Controller
{
    /**
     * List all questions that evaluate the given skill
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Skill $skill): ResourceCollection
    {
        $questions = $skill->questions()->latest()->paginate();

        return QuestionResource::collection($questions);
    }
}
