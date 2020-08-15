<?php

return [
	'route' => [
		'prefix' => [
			'recruiterarea' => 'recruiter',
			'applicantarea' => 'applicant',
			'guestarea' => 'guest',
			'adminarea' => 'admin',
		]
	],

	'evaluation_model' => [
		'endpoint' => env('EVALUATION_MODEL_ENDPOINT'),
		'token' => env('EVALUATION_MODEL_TOKEN'),
	],

	'feedback_model' => [
		'endpoint' => env('FEEDBACK_MODEL_ENDPOINT'),
		'token' => env('FEEDBACK_MODEL_TOKEN'),
	],

	'threshold' => 6,
];