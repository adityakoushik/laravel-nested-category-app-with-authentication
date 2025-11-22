@extends('layouts.app')

@section('content')
	<div class="container mx-auto py-8">
		<div class="bg-white rounded shadow p-6">
			<h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
			<nav class="mb-4">
				<a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Admin Dashboard</a>
				<span class="mx-2">|</span>
				<a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">User List</a>
				<span class="mx-2">|</span>
				<a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">Categories</a>
				<span class="mx-2">|</span>
				<a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:underline">Go to User Dashboard</a>
			</nav>
			<div class="border-t pt-4">
				<h2 class="text-xl font-semibold mb-2">Nested Categories (Tree View)</h2>
				<ul class="ml-4">
					@foreach($categories as $category)
						@include('admin.categories.partials.category_tree', ['category' => $category])
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endsection