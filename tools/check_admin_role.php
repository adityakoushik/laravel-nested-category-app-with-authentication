<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'admin@example.com';
$user = User::where('email', $email)->first();
if (!$user) {
	echo "MISSING\n";
	exit(1);
}

$roles = method_exists($user, 'getRoleNames') ? $user->getRoleNames()->toArray() : [];
echo json_encode(['email' => $email, 'id' => $user->id, 'roles' => $roles], JSON_PRETTY_PRINT) . "\n";

exit(0);
