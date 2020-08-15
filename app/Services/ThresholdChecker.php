<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ThresholdChecker
{
	/**
	 * Evaluate the given answer compared to the given model answers
	 *
	 * @return boolean
	 */
	public function check(string $value): bool
	{
		return $value < config('hrbot.threshold');
	}
}