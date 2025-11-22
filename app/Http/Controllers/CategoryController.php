<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('can:isAdmin');
	}

	public function index()
	{
		$categories = Category::whereNull('parent_id')->with('children')->get();
		return view('admin.categories.index', compact('categories'));
	}

	public function create()
	{
		$categories = Category::all();
		return view('admin.categories.create', compact('categories'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'parent_id' => 'nullable|exists:categories,id',
		]);
		Category::create($request->only('name', 'parent_id'));
		return redirect()->route('admin.categories.index')->with('success', 'Category created.');
	}

	public function edit(Category $category)
	{
		$categories = Category::where('id', '!=', $category->id)->get();
		return view('admin.categories.edit', compact('category', 'categories'));
	}

	public function update(Request $request, Category $category)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'parent_id' => 'nullable|exists:categories,id',
		]);
		$category->update($request->only('name', 'parent_id'));
		return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
	}

	public function destroy(Category $category)
	{
		$category->delete();
		return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
	}
}
