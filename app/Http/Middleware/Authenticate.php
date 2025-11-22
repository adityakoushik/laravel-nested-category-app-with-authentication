<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	// You can customize the redirect path if needed
	protected function redirectTo($request)
	{
		if (!$request->expectsJson()) {
			return route('login');
		}
	}
}
