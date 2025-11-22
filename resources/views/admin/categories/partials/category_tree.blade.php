<li class="mb-2">
	<div class="flex items-center justify-between node-row">
		<div class="flex items-center">
			<div class="node-controls mr-3">
				@if(isset($category->children) && $category->children->count())
					<button type="button"
						class="toggle-btn inline-flex items-center justify-center w-7 h-7 rounded border text-sm">−</button>
				@endif
			</div>

			<span class="node-label font-medium text-gray-800">{{ $category->name }}</span>
		</div>

		<div class="flex items-center gap-2">
			<a href="{{ route('admin.categories.edit', $category) }}" class="text-sm text-blue-600 hover:underline">Edit</a>

			<form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
				onsubmit="return confirm('Delete this category?')">
				@csrf
				@method('DELETE')
				<button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
			</form>
		</div>
	</div>

	@if(isset($category->children) && $category->children->count())
		<ul class="ml-6 mt-2">
			@foreach($category->children as $child)
				@include('admin.categories.partials.category_tree', ['category' => $child])
			@endforeach
		</ul>
	@endif
</li>