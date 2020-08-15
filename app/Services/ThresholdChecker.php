<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ThresholdChecker
{
	/**
	 * threshold to compare the values to
	 * 
	 * @var float
	 */
	protected $threshold;

	public function __construct(?float $threshold = null)
	{
		if (is_null($threshold)) {
			$this->threshold = config('hrbot.threshold');
		} else {
			$this->threshold = $threshold;
		}
	}

	/**
	 * Evaluate the given answer compared to the given model answers
	 *
	 * @return boolean
	 */
	public function check(string $value): bool
	{
		return $value < $this->threshold;
	}
}