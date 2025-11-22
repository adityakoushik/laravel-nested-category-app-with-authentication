@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>User List</h1>
		<nav>
			<a href="{{ route('admin.dashboard') }}">Admin Dashboard</a> |
			<a href="{{ route('admin.categories.index') }}">Categories</a>
		</nav>
		<hr>
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ ($user->getRoleNames()->count() ? $user->getRoleNames()->join(', ') : '—') }}</td>
						<td>
							<a href="{{ route('admin.users.dashboard', $user) }}">View Dashboard</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection