<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Skill;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\RecruiterArea\QuestionResource;
use App\Http\Requests\RecruiterArea\QuestionsListingFormRequest;

class QuestionsController extends Controller
{
    /**
     * List all questions that evaluate the given skill
     *
     * @param  \App\Http\Requests\RecruiterArea\QuestionsListingFormRequest  $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(QuestionsListingFormRequest $request): ResourceCollection
    {

        $query = Question::latest();

        $query = $this->applyIndexFilters($request, $query);

        $questions = $query->paginate();

        return QuestionResource::collection($questions);
    }

    /**
     * Apply the index function filters
     * 
     * @param  \Illuminate\Http\Request                     $request 
     * @param  \Illuminate\Database\Eloquent\Builder        $query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyIndexFilters(Request $request, Builder $query): Builder
    {

        $filters = $request->validated();

        if(isset($filters['skills']) && !empty($filters['skills'])){
            $query = $query->whereIn('skill_id', $filters['skills']);
        }

        return $query;
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
