<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function setUp(): void
	{
		parent::setUp();

		// Ensure tests use array sessions so StartSession won't hit DB
		config(['session.driver' => 'array']);

		// Disable CSRF middleware for tests to avoid 419s when tests post without tokens
		$this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

		// Use array cache for tests so rate limiting and notifications are ephemeral
		config(['cache.default' => 'array']);
	}
}
