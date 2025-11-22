@extends('layouts.app')

@section('content')
	<div class="container mx-auto py-8">
		<div class="bg-white rounded shadow p-6">
			<h1 class="text-2xl font-bold mb-4">User List</h1>

			<nav class="mb-4">
				<a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Admin Dashboard</a>
				<span class="mx-2">|</span>
				<a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">Categories</a>
			</nav>

			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						@foreach($users as $user)
							<tr>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm">
									@forelse($user->getRoleNames() as $role)
										<span
											class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">{{ $role }}</span>
									@empty
										<span class="text-sm text-gray-400">—</span>
									@endforelse
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									<a href="{{ route('admin.users.dashboard', $user) }}" class="text-blue-600 hover:underline mr-4">View</a>

								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection