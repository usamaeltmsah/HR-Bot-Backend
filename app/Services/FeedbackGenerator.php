<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FeedbackGenerator
{
	/**
	 * Generate feedback for the given skills
	 * 
	 * @param  array  $skills 
	 * @return array
	 */
	public function generate(array $skills): array
	{
		$body = [
			'skills' => $skills,
			'token' => config('hrbot.feedback_model.token'),
		];

		$response = Http::post(config('hrbot.feedback_model.endpoint'), $body);

		return $response['feedback'];
	}
}