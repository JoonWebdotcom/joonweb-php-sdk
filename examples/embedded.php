<?php
/**
 * Minimal embedded example: reads token/site from SessionManager and
 * demonstrates calling the SDK to fetch site and products.
 */
require __DIR__ . '/vendor/autoload.php';

use JoonWeb\JoonWebAPI;
use JoonWeb\Auth\SessionManager;

$sm = new SessionManager();
if (!method_exists($sm, 'isAuthenticated') || !$sm->isAuthenticated()) {
    echo "Not authenticated. <a href='auth/install.php?site=example.myjoonweb.com'>Install</a>";
    exit;
}

$api = new JoonWebAPI();
$api->setAccessToken($sm->getAccessToken());
$api->setSiteDomain($sm->getSiteDomain());

try {
    $site = $api->getSite();
    echo '<h1>Site: ' . htmlspecialchars($site['name'] ?? 'Unknown') . '</h1>';

    $products = $api->product->all(['limit' => 10]);
    echo '<h2>Products</h2><ul>';
    foreach ($products as $p) {
        echo '<li>' . htmlspecialchars($p['title'] ?? $p['name'] ?? 'Untitled') . '</li>';
    }
    echo '</ul>';
} catch (Exception $e) {
    echo 'API error: ' . htmlspecialchars($e->getMessage());
}
