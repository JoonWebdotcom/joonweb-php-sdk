<?php
/**
 * Minimal bootstrap for examples.
 * - Loads Composer autoload
 * - Initializes JoonWeb\Context if present
 * - Starts a PHP session
 */
require __DIR__ . '/../vendor/autoload.php';

use JoonWeb\Context;

// Initialize context (reads values from env or constants if available)
Context::init([
    'api_key' => getenv('JOONWEB_CLIENT_ID') ?: null,
    'api_secret' => getenv('JOONWEB_CLIENT_SECRET') ?: null,
    'api_version' => getenv('JOONWEB_API_VERSION') ?: '26.0',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Example: make sure session is available to example pages
$_SESSION['__joonweb_examples_bootstrapped'] = true;

echo "Bootstrap complete.\n";
