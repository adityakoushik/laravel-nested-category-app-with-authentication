@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Categories</h1>
		<a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
		@if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif
		<ul>
			@foreach($categories as $category)
				@include('admin.categories.partials.category_tree', ['category' => $category])
			@endforeach
		</ul>
	</div>
@endsection