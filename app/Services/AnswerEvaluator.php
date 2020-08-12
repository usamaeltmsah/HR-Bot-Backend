<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AnswerEvaluator
{
	/**
	 * Evaluate the given answer compared to the given model answers
	 * 
	 * @param  string $answer       
	 * @param  array  $modelAnswers 
	 * @return float
	 */
	public function evaluate(string $answer, array $modelAnswers): float
	{
		$body = [
			'applicant_answer' => $answer,
			'answers' => $modelAnswers,
			'token' => config('hrbot.evaluation_model.token'),
		];

		$response = Http::post(config('hrbot.evaluation_model.endpoint'), $body);

		return (float) $response['score'];
	}
}