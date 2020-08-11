<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Skill;
use App\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\RecruiterArea\QuestionResource;

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * 
     * @return \App\Http\Resources\RecruiterArea\QuestionResource
     */
    public function show(Question $question): QuestionResource
    {
        return new QuestionResource($question);
    }
}
