<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Visit;
use Illuminate\Contracts\Console\Kernel;

echo "--- USERS ---\n";
foreach (User::all() as $user) {
    echo "ID: {$user->user_id}, Name: {$user->name}, Username: {$user->username}, Role: '{$user->role}'\n";
}

echo "\n--- PENDING VISITS ---\n";
foreach (Visit::where('status', 'Pending')->get() as $visit) {
    echo "ID: {$visit->visit_id}, Pass: {$visit->pass_number}, Host Signature: ".($visit->host_signature ? 'YES' : 'NO')."\n";
}
