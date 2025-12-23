<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

// create user
$user = User::create([
    'name' => 'Mail Test',
    'email' => 'mailtest@example.com',
    'password' => Hash::make('secret123'),
]);

// fire Registered event
event(new Registered($user));

echo "Created user id={$user->id} and fired Registered event\n";
