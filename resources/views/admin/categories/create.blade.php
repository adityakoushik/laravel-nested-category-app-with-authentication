@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Add Category</h1>
		<form method="POST" action="{{ route('admin.categories.store') }}">
			@csrf
			<div class="mb-3">
				<label for="name" class="form-label">Name</label>
				<input type="text" name="name" id="name" class="form-control" required>
			</div>
			<div class="mb-3">
				<label for="parent_id" class="form-label">Parent Category</label>
				<select name="parent_id" id="parent_id" class="form-control">
					<option value="">None</option>
					@foreach($categories as $cat)
						<option value="{{ $cat->id }}">{{ $cat->name }}</option>
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-success">Create</button>
		</form>
	</div>
@endsection