<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$email = 'admin@gmail.com';

		$user = User::where('email', $email)->first();

		if (!$user) {
			$user = User::create([
				'name' => 'Admin',
				'email' => $email,
				'password' => Hash::make('12345678'),
			]);
		} else {
			$user->name = 'Admin';
			$user->password = Hash::make('12345678');
			$user->save();
		}

		// Ensure an 'admin' role exists and assign it to the user
		Role::firstOrCreate(['name' => 'admin']);
		$user->assignRole('admin');
	}
}
