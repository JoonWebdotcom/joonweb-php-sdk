<?php
/**
 * Simple install redirect for the OAuth install flow.
 * Usage: examples/auth/install.php?site=your-site.myjoonweb.com
 */
require __DIR__ . '/../../vendor/autoload.php';

$site = $_GET['site'] ?? null;
$clientId = getenv('JOONWEB_CLIENT_ID') ?: null;
$redirectUri = getenv('JOONWEB_REDIRECT_URI') ?: null;

if (!$site || !$clientId || !$redirectUri) {
    http_response_code(400);
    echo "Missing required parameters or environment variables (JOONWEB_CLIENT_ID, JOONWEB_REDIRECT_URI).";
    exit;
}

$installUrl = sprintf(
    'https://%s/admin/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=code',
    $site,
    urlencode($clientId),
    urlencode($redirectUri)
);

header('Location: ' . $installUrl);
exit;
