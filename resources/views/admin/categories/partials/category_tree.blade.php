<li>
	{{ $category->name }}
	<a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
	<form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline">
		@csrf
		@method('DELETE')
		<button type="submit" onclick="return confirm('Delete this category?')">Delete</button>
	</form>
	@if($category->children->count())
		<ul>
			@foreach($category->children as $child)
				@include('admin.categories.partials.category_tree', ['category' => $child])
			@endforeach
		</ul>
	@endif
</li>