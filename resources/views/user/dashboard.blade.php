@extends('layouts.app')

@section('content')
	<div class="container mx-auto py-8">
		<div class="bg-white rounded shadow p-6">
			<h1 class="text-2xl font-bold mb-4">User Dashboard</h1>

			<div class="border-t pt-4">
				<p class="text-lg">Welcome, <span class="font-semibold">{{ $user->name ?? auth()->user()->name }}</span>!</p>
				<p class="text-gray-700">Role: <span
						class="font-semibold">{{ ($user->getRoleNames()->count() ? $user->getRoleNames()->join(', ') : '—') }}</span>
				</p>
			</div>
		</div>
	</div>
@endsection