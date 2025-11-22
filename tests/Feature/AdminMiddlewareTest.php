<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminMiddlewareTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();

		// Ensure the admin role exists
		Role::firstOrCreate(['name' => 'admin']);
	}

	public function test_admin_can_access_admin_dashboard()
	{
		$admin = User::factory()->create();
		$admin->assignRole('admin');

		$response = $this->actingAs($admin)->get(route('admin.dashboard'));

		$response->assertStatus(200);
	}

	public function test_user_cannot_access_admin_dashboard()
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user)->get(route('admin.dashboard'));

		$response->assertStatus(403);
	}

	public function test_admin_can_view_other_users_dashboard()
	{
		$admin = User::factory()->create();
		$admin->assignRole('admin');

		$other = User::factory()->create(['name' => 'Other User']);

		$response = $this->actingAs($admin)->get(route('admin.users.dashboard', $other));

		$response->assertStatus(200);
		$response->assertSee('Other User');
		$response->assertSee('Return to Admin');
	}

	public function test_non_admin_does_not_see_admin_links_in_nav()
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user)->get(route('user.dashboard'));

		// Admin dashboard link should not be present for normal users
		$response->assertDontSee(route('admin.dashboard'));
	}
}
