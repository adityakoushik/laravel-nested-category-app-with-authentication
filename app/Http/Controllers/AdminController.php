<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


	public function dashboard()
	{
		$categories = Category::whereNull('parent_id')->with('children')->get();
		return view('admin.dashboard', compact('categories'));
	}

	public function users()
	{
		$users = User::all();
		return view('admin.users.index', compact('users'));
	}

	public function viewUserDashboard(User $user)
	{
		return view('user.dashboard', ['user' => $user]);
	}
}
