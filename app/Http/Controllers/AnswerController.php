<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\AnswerResourceCollection;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnswerResourceCollection|\Illuminate\Http\Response
     */
    public function index():AnswerResourceCollection
    {
        return new AnswerResourceCollection(Answer::paginate());
    }

    /**dispatchesEvents
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return AnswerResource|\Illuminate\Http\Response
     */
    public function store(Request $request):AnswerResource
    {
        $request->validate([
            // 'score' => 'required',
            'body' => 'required',
            'question_id' => 'required',
        ]);
        $answer = Answer::create($request->all());
        return new AnswerResource($answer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return AnswerResource
     */
    public function show(Answer $answer):AnswerResource
    {
        return new AnswerResource(Answer::firstWhere('id', $answer->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Answer $answer
     * @return AnswerResource|\Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer):AnswerResource
    {
        $answer->update($request->all());

        return new AnswerResource($answer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();

        return response()->json();
    }


    /**
     * Evaluate the given Answer
     * @param string $answerBody
     * @return float $score
     */
    public static function evalAnswer($answerBody)
    {
//        $score = "GET(API)";

        $score = 5.0;
        /*
         *
         * ToDo: Receive score from evalModel, and save it in score variable
         *
         * */
        return $score;
    }
}
