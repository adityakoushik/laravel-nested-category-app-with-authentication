<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$email = 'admin@example.com';

		$user = User::where('email', $email)->first();

		if (!$user) {
			$user = User::create([
				'name' => 'Admin',
				'email' => $email,
				'password' => Hash::make('password123'),
			]);
		} else {
			$user->name = 'Admin';
			$user->password = Hash::make('password123');
			$user->save();
		}

		// Ensure role is set to admin (use forceFill to bypass mass-assignment restrictions)
		$user->forceFill(['role' => 'admin'])->save();
	}
}
