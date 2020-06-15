<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionResourceCollection;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return QuestionResourceCollection|\Illuminate\Http\Response
     */
    public function index():QuestionResourceCollection
    {
        return new QuestionResourceCollection(Question::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return QuestionResource|\Illuminate\Http\Response
     */
    public function store(Request $request):QuestionResource
    {
        $request->validate([
            'body' => 'required',
        ]);

        $question = Question::create($request->all());
        return new QuestionResource($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question $question
     * @return QuestionResource|\Illuminate\Http\Response
     */
    public function show(Question $question):QuestionResource
    {
        return new QuestionResource(Question::firstWhere('id', $question->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Question $question
     * @return QuestionResource|\Illuminate\Http\Response
     */
    public function update(Request $request, Question $question):QuestionResource
    {
        $question->update($request->all());

        return new QuestionResource($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json();
    }
}
