<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource as a nested tree.
	 */
	public function index()
	{
		$all = Category::orderBy('name')->get();

		$itemsByParent = $all->groupBy('parent_id');

		$build = function ($parentId) use (&$build, $itemsByParent) {
			$nodes = $itemsByParent->get($parentId, collect());

			return $nodes->map(function ($item) use ($build) {
				$item->children = $build($item->id);
				return $item;
			});
		};

		$tree = $build(null);

		return view('admin.categories.index', compact('tree'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$all = Category::orderBy('name')->get();

		$itemsByParent = $all->groupBy('parent_id');

		$buildOptions = function ($parentId = null, $depth = 0) use (&$buildOptions, $itemsByParent) {
			$nodes = $itemsByParent->get($parentId, collect());
			$out = collect();
			foreach ($nodes as $node) {
				$out->push([
					'id' => $node->id,
					'name' => $node->name,
					'depth' => $depth,
					'display' => str_repeat('-- ', $depth) . $node->name,
				]);
				$out = $out->merge($buildOptions($node->id, $depth + 1));
			}
			return $out;
		};

		$categories = $buildOptions();

		return view('admin.categories.create', compact('categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'parent_id' => ['nullable', 'exists:categories,id'],
		]);

		Category::create($data);

		return redirect()->route('admin.categories.index')->with('success', 'Category created.');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Category $category)
	{
		$all = Category::orderBy('name')->get();

		// compute descendants to prevent selecting parent as a descendant
		$descendants = [];

		$childrenMap = $all->groupBy('parent_id');

		$collectDescendants = function ($id) use (&$collectDescendants, $childrenMap, &$descendants) {
			$children = $childrenMap->get($id, collect());
			foreach ($children as $child) {
				$descendants[] = $child->id;
				$collectDescendants($child->id);
			}
		};

		$collectDescendants($category->id);

		$available = $all->reject(function ($c) use ($category, $descendants) {
			return $c->id === $category->id || in_array($c->id, $descendants);
		});

		$itemsByParent = $available->groupBy('parent_id');

		$buildOptions = function ($parentId = null, $depth = 0) use (&$buildOptions, $itemsByParent) {
			$nodes = $itemsByParent->get($parentId, collect());
			$out = collect();
			foreach ($nodes as $node) {
				$out->push([
					'id' => $node->id,
					'name' => $node->name,
					'depth' => $depth,
					'display' => str_repeat('-- ', $depth) . $node->name,
				]);
				$out = $out->merge($buildOptions($node->id, $depth + 1));
			}
			return $out;
		};

		$categories = $buildOptions();

		return view('admin.categories.edit', [
			'category' => $category,
			'categories' => $categories,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Category $category)
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'parent_id' => ['nullable', 'exists:categories,id'],
		]);

		// update category
		// prevent self-parenting
		if (isset($data['parent_id']) && $data['parent_id'] == $category->id) {
			return back()->withErrors(['parent_id' => 'Invalid parent category.'])->withInput();
		}

		$category->update($data);

		return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Category $category)
	{
		$category->delete();
		return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
	}
}

