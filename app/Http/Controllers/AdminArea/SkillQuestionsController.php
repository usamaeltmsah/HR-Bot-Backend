<?php

namespace App\Http\Controllers\AdminArea;

use App\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminArea\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Requests\AdminArea\SkillQuestionFormRequest;

class SkillQuestionsController extends Controller
{
	/**
	 * List all the questions attached to the given skill
	 * 
	 * @param  \App\Skill  $skill
	 * @return \Illuminate\Http\Resources\Json\ResourceCollection
	 */
    public function index(Skill $skill): ResourceCollection
    {
    	$questions = $skill->questions()->paginate();

    	return QuestionResource::collection($questions);
    }

    /**
     * Create a new question with the given data attached to the given skill
     * 
     * @param  \App\Http\Requests\AdminArea\SkillQuestionFormRequest $request
     * @param  \App\Skill               $skill
     * 
     * @return \App\Http\Resources\AdminArea\QuestionResource
     */
    public function store(SkillQuestionFormRequest $request, Skill $skill): QuestionResource
    {
    	$data = $request->validated();

    	$question = $skill->questions()->create($data);

    	return new QuestionResource($question);
    }
}
