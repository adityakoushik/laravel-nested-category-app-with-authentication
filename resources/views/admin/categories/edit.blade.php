@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Edit Category</h1>
		<form method="POST" action="{{ route('admin.categories.update', $category) }}">
			@csrf
			@method('PUT')
			<div class="mb-3">
				<label for="name" class="form-label">Name</label>
				<input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
			</div>
			<div class="mb-3">
				<label for="parent_id" class="form-label">Parent Category</label>
				<select name="parent_id" id="parent_id" class="form-control">
					<option value="">None</option>
					@foreach($categories as $cat)
						<option value="{{ $cat->id }}" @if($category->parent_id == $cat->id) selected @endif>{{ $cat->name }}</option>
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		</form>
	</div>
@endsection