<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{


	public function dashboard()
	{
		return view('user.dashboard', ['user' => Auth::user()]);
	}
}
