<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// $app->handleRequest(Request::capture());
/*
 * CHANGE: Replaced the old custom handleRequest() method
 * with Laravel's modern HTTP kernel handling.
 */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Capture the incoming request
$request = Request::capture();

// Handle the request through the kernel (routes, middleware, controllers)
$response = $kernel->handle($request);

// Send the response to the browser
$response->send();

// Terminate the kernel (cleanup, terminate middleware, etc.)
$kernel->terminate($request, $response);