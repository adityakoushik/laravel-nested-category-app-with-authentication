<?php

// Legacy migration converted to no-op because roles are managed
// by spatie/laravel-permission. The original migration added a
// `role` string column to `users`. Keep this file as a no-op so
// it doesn't reintroduce the column when running migrations on
// other environments.

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	public function up(): void
	{
		// no-op
	}

	public function down(): void
	{
		// no-op
	}
};
