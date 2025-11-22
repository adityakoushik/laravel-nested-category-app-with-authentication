@extends('layouts.app')

@section('content')
	<div class="max-w-3xl mx-auto px-4 py-8">
		<div class="mb-6 flex items-center justify-between">
			<h1 class="text-2xl font-semibold text-gray-800">Create Category</h1>
			<a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:underline">Back to list</a>
		</div>

		@if($errors->any())
			<div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800">
				<ul class="list-disc pl-5">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white border rounded p-6 shadow-sm">
			@csrf

			<div class="mb-4">
				<label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
				<input id="name" name="name" value="{{ old('name') }}" required
					class="w-full px-3 py-2 border rounded focus:outline-none focus:ring" />
			</div>

			<div class="mb-4">
				<label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
				<select id="parent_id" name="parent_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring">
					<option value="">None</option>
					@foreach($categories as $cat)
						<option value="{{ $cat['id'] }}" {{ old('parent_id') == $cat['id'] ? 'selected' : '' }}>{{ $cat['display'] }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="flex items-center gap-3">
				<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create</button>
				<a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
			</div>
		</form>
	</div>
@endsection