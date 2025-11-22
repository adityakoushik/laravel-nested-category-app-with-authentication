@extends('layouts.app')

@section('content')
	<div class="container mx-auto py-8">
		<div class="bg-white rounded shadow p-6">
			<h1 class="text-2xl font-bold mb-4">User Dashboard</h1>

			<div class="border-t pt-4">
				@if(optional(auth()->user())->hasRole('admin') && isset($user) && $user->id !== auth()->id())
					<div class="mb-4 p-3 bg-yellow-50 border-l-4 border-yellow-300 flex items-center justify-between">
						<div>
							<strong class="block">Viewing as Admin</strong>
							<span class="text-sm text-gray-700">You are viewing <span class="font-semibold">{{ $user->name }}</span>'s
								dashboard.</span>
						</div>
						<div>
							<a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline">Return to Admin
								Dashboard</a>
						</div>
					</div>
				@endif

				<p class="text-lg">Welcome, <span class="font-semibold">{{ $user->name ?? auth()->user()->name }}</span>!</p>
				<p class="text-gray-700">Role: <span
						class="font-semibold">{{ ($user->getRoleNames()->count() ? $user->getRoleNames()->join(', ') : 'user') }}</span>
				</p>
			</div>
		</div>
	</div>
@endsection