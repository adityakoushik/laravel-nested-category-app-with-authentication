<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminLoginTest extends TestCase
{
	use RefreshDatabase;

	public function test_admin_is_redirected_to_admin_dashboard_after_login()
	{
		// Disable CSRF middleware for this test POST
		// Request the login page first to establish a session and CSRF token.
		$this->get('/login');

		$token = csrf_token();

		// Ensure role exists
		Role::firstOrCreate(['name' => 'admin']);

		$password = 'secret123';
		$admin = User::factory()->create([
			'email' => 'admin@example.test',
			'password' => bcrypt($password),
			'name' => 'Admin',
		]);

		$admin->assignRole('admin');

		$response = $this->followingRedirects()
			->post('/login', [
				'_token' => $token,
				'email' => $admin->email,
				'password' => $password,
			]);

		$response->assertStatus(200);
		// Admin dashboard should be shown
		$response->assertSee('Dashboard');
		// Nav should indicate admin link (optional)
		$response->assertSee(route('admin.dashboard'));
	}
}
