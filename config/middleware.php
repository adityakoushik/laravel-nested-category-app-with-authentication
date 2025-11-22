<?php

return [
	'aliases' => [
		'auth' => \App\Http\Middleware\Authenticate::class,
		'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
		// Add other middleware aliases here
	],
];
