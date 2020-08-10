<?php

namespace App\Http\Controllers\AdminArea;

use App\Skill;
use App\Question;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminArea\QuestionResource;
use App\Http\Requests\AdminArea\QuestionFormRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionsController extends Controller {

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
     * @param  \App\Http\Requests\AdminArea\QuestionFormRequest $request
     * @param  \App\Skill               $skill
     * 
     * @return \App\Http\Resources\AdminArea\QuestionResource
     */
    public function store(QuestionFormRequest $request, Skill $skill): QuestionResource
    {
      $data = $request->validated();

      $question = $skill->questions()->create($data);

      return new QuestionResource($question);
    }

    /**
     * Get the question with the given id
     * 
     * @param  \App\Question $question
     * 
     * @return \App\Http\Resources\AdminArea\QuestionResource
     */
    public function show(Question $question): QuestionResource 
    {
        return new QuestionResource($question);
    }

   /**
    * Update the specified question in storage.
    *
    * @param  \App\Http\Requests\AdminArea\QuestionFormRequest $request
    * @param  \App\Question $question
    * 
    * @return \App\Http\Resources\QuestionResource
    */
   public function update(QuestionFormRequest $request, Question $question): QuestionResource 
   {
       $question->update($request->validated());
       
       return new QuestionResource($question);
   }

   /**
    * Remove the specified question from storage.
    *
    * @param  \App\Question  $question
    * 
    * @return \Illuminate\Http\Response
    */
   public function destroy(Question $question): Response 
   {
       $question->delete();

       return response(null, 204);
   }
}
