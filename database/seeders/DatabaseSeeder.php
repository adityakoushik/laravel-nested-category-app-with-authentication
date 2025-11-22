<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// Create admin first (only via seeder)
		$this->call(AdminUserSeeder::class);

		// Example/test user(s) - create only if not exists
		// User::factory(10)->create();

		User::firstOrCreate([
			'email' => 'test@gmail.com',
		], [
			'name' => 'Test User',
			'email_verified_at' => now(),
			'password' => Hash::make('12345678'),
		]);
	}
}
