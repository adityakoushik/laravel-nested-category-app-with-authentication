@extends('layouts.app')

@section('content')
	<div class="max-w-6xl mx-auto px-4 py-8">
		<div class="flex items-center justify-between mb-6">
			<h1 class="text-2xl font-semibold text-gray-800">Categories</h1>

			<div class="flex items-center gap-3">
				<a href="{{ route('admin.categories.create') }}"
					class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Category</a>
				<a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:underline">Admin Dashboard</a>
			</div>
		</div>

		@if(session('success'))
			<div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
		@endif

		<div class="flex flex-col md:flex-row gap-6">
			<aside class="md:w-72 bg-white border rounded p-4 shadow-sm">
				<label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
				<input id="category-search" type="search" placeholder="Search categories..."
					class="w-full px-3 py-2 border rounded focus:outline-none focus:ring" />

				<div class="mt-4 space-y-2">
					<button id="expand-all" class="w-full text-left text-sm text-gray-700 hover:underline">Expand all</button>
					<button id="collapse-all" class="w-full text-left text-sm text-gray-700 hover:underline">Collapse all</button>
				</div>
			</aside>

			<main class="flex-1 bg-white border rounded p-4 shadow-sm">
				<div class="overflow-auto">
					<ul id="category-tree" class="space-y-2">
						@foreach($tree as $category)
							@include('admin.categories.partials.category_tree', ['category' => $category])
						@endforeach
					</ul>
				</div>
			</main>
		</div>
	</div>

	<script>
		// Expand/collapse and search behaviour
		document.addEventListener('DOMContentLoaded', function () {
			const tree = document.getElementById('category-tree');
			const search = document.getElementById('category-search');

			function setCollapsed(el, collapsed) {
				const child = el.querySelector(':scope > ul');
				const btn = el.querySelector(':scope > .node-controls > .toggle-btn');
				if (!child) return;
				if (collapsed) {
					child.classList.add('hidden');
					if (btn) btn.textContent = '+';
				} else {
					child.classList.remove('hidden');
					if (btn) btn.textContent = '−';
				}
			}

			document.getElementById('expand-all').addEventListener('click', function (e) {
				e.preventDefault();
				tree.querySelectorAll('li').forEach(li => setCollapsed(li, false));
			});
			document.getElementById('collapse-all').addEventListener('click', function (e) {
				e.preventDefault();
				tree.querySelectorAll('li').forEach(li => setCollapsed(li, true));
			});

			// Search: simple highlight and collapse non-matching branches
			search.addEventListener('input', function () {
				const q = this.value.trim().toLowerCase();
				tree.querySelectorAll('li').forEach(li => {
					const label = li.querySelector(':scope > .node-row > .node-label');
					if (!label) return;
					const text = label.textContent.trim().toLowerCase();
					if (!q) {
						li.classList.remove('hidden-by-filter');
						// show all
						setCollapsed(li, false);
						label.classList.remove('bg-yellow-100');
						return;
					}
					const match = text.includes(q);
					label.classList.toggle('bg-yellow-100', match);
					// if match, show ancestors
					if (match) {
						let p = li.parentElement;
						while (p && p.id !== 'category-tree') {
							if (p.tagName.toLowerCase() === 'li') setCollapsed(p, false);
							p = p.parentElement;
						}
						li.classList.remove('hidden-by-filter');
					} else {
						// hide non-matching leaf nodes; internal nodes remain visible if children match
						const child = li.querySelector(':scope > ul');
						const anyChildMatch = child && child.querySelector('.node-label.bg-yellow-100');
						li.classList.toggle('hidden-by-filter', !anyChildMatch);
					}
				});
			});
		});
	</script>

	<style>
		/* Small helper: hide nodes filtered out */
		.hidden-by-filter {
			display: none !important;
		}
	</style>

@endsection