<?php

namespace App\Http\Controllers\AdminArea;

use App\Question;
use App\ModelAnswer;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminArea\ModelAnswerResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Requests\AdminArea\ModelAnswerFormRequest;

class ModelAnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Question  $question
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Question $question): ResourceCollection
    {
        $modelAnswers = $question->modelAnswers()->paginate();

        return ModelAnswerResource::collection($modelAnswers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdminArea\ModelAnswerFormRequest  $request
     * @param  \App\Question                                                $question
     * @return \App\Http\Resources\AdminArea\ModelAnswerResource
     */
    public function store(ModelAnswerFormRequest $request, Question $question): ModelAnswerResource
    {
        $data = $request->validated();

        $modelAnswer = $question->modelAnswers()->create($data);
        
        return new ModelAnswerResource($modelAnswer);
    }

    /**
     * Show a specific resource
     * 
     * @param  \App\ModelAnswer $modelAnswer
     * 
     * @return \App\Http\Resources\AdminArea\ModelAnswerResource
     */
    public function show(ModelAnswer $modelAnswer): ModelAnswerResource 
    {
        return new ModelAnswerResource($modelAnswer);
    }

   /**
    * Update the specified model answer in storage.
    *
    * @param  \App\Http\Requests\AdminArea\ModelAnswerFormRequest $request
    * @param  \App\ModelAnswer $modelAnswer
    * 
    * @return \App\Http\Resources\ModelAnswerResource
    */
   public function update(ModelAnswerFormRequest $request, ModelAnswer $modelAnswer): ModelAnswerResource 
   {
       $modelAnswer->update($request->validated());
       
       return new ModelAnswerResource($modelAnswer);
   }

   /**
    * Remove the specified model answer from storage.
    *
    * @param  \App\ModelAnswer  $modelAnswer
    * 
    * @return \Illuminate\Http\Response
    */
   public function destroy(ModelAnswer $modelAnswer): Response 
   {
       $modelAnswer->delete();

       return response(null, 204);
   }
}
