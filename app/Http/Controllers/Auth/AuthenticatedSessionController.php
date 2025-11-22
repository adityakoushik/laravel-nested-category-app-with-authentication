<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
	/**
	 * Display the login view.
	 */
	public function create(Request $request): View
	{
		// If an intended URL points to the user dashboard, clear it so admins
		// are not sent there after login. Compare only the path for robustness.
		if ($request->session()->has('url.intended')) {
			$path = parse_url($request->session()->get('url.intended'), PHP_URL_PATH) ?: '';
			if (str_ends_with($path, '/dashboard')) {
				$request->session()->forget('url.intended');
			}
		}

		return view('auth.login');
	}

	/**
	 * Handle an incoming authentication request.
	 */
	public function store(LoginRequest $request): RedirectResponse
	{
		$request->authenticate();

		$request->session()->regenerate();

		$user = Auth::user();


		if ($user && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
			// Clear any stored intended URL that may point to non-admin pages
			// and send admins to the admin dashboard.
			$request->session()->forget('url.intended');

			return redirect()->route('admin.dashboard');
		}

		// Non-admins: respect intended URL if present, otherwise go to user dashboard.
		return redirect()->intended(route('user.dashboard'));
	}

	/**
	 * Destroy an authenticated session.
	 */
	public function destroy(Request $request): RedirectResponse
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/');
	}
}
