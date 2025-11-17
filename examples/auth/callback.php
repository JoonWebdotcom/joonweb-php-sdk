<?php
/**
 * Example OAuth callback: exchanges authorization code for an access token
 * using the SDK and persists the resulting token using the repo's
 * SessionManager (if present).
 *
 * Note: Adjust SessionManager usage to match your app's session storage API.
 */
require __DIR__ . '/../../vendor/autoload.php';

use JoonWeb\JoonWebAPI;
use JoonWeb\Auth\SessionManager;

$site = $_GET['site'] ?? null;
$code = $_GET['code'] ?? null;

if (!$site || !$code) {
    http_response_code(400);
    echo "Missing 'site' or 'code' in callback.";
    exit;
}

$api = new JoonWebAPI();
try {
    $resp = $api->exchangeCodeForToken($code, $site);
} catch (Exception $e) {
    http_response_code(500);
    echo "Token exchange failed: " . $e->getMessage();
    exit;
}

$accessToken = $resp['access_token'] ?? null;
if (!$accessToken) {
    http_response_code(500);
    echo "No access token returned from token exchange.";
    exit;
}

// Persist token/site using the repo SessionManager if available
// The repository provides JoonWeb\Auth\SessionManager with methods like startSession()
if (class_exists(SessionManager::class)) {
    $sm = new SessionManager();
    if (method_exists($sm, 'startSession')) {
        $sm->startSession($site, $accessToken);
    }
}

// Redirect to the example embedded page
header('Location: /examples/embedded.php');
exit;
