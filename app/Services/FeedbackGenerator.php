<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FeedbackGenerator
{
	/**
	 * Generate feedback for the given skills
	 * 
	 * @param  array  $skills 
	 * @return string
	 */
	public function generate(array $skills): string
	{
		$body = [
			'skills' => $skills,
			'token' => config('hrbot.feedback_model.token'),
		];

		$response = Http::post(config('hrbot.feedback_model.endpoint'), $body);

		return (string) json_encode($response['feedback']);
	}
}