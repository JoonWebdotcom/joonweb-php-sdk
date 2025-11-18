# JoonWeb PHP SDK

Professional PHP SDK for building applications on the JoonWeb platform.

## Installation
```bash
composer require joonweb/joonweb-sdk
```

### Requirements
- PHP 8.0+
- cURL extension
- JSON extension
 
## Quick bootstrap (framework-agnostic example)

Add a tiny bootstrap before using the SDK in your app. This example shows how to initialize the context and use the repository-provided `SessionManager` (replace with your own persistent storage in production):

```php
require 'vendor/autoload.php';
use JoonWeb\Context;
use JoonWeb\Auth\SessionManager; // repo-provided session manager

Context::init([
    'api_key' => getenv('JOONWEB_CLIENT_ID'),
    'api_secret' => getenv('JOONWEB_CLIENT_SECRET'),
    'api_version' => getenv('JOONWEB_API_VERSION') ?: '26.0',
    'is_embedded' => false,
    // Optional: provide your own session storage implementation. By default the repo's SessionManager will be used if present.
    // 'session_storage' => new SessionManager(),
]);

$api = new JoonWeb\JoonWebAPI();
$api->setAccessToken(/* access token from your session or OAuth flow */)
        ->setSiteDomain('example.myjoonweb.com');
```

Notes:
- Replace `SessionManager` with a persistent implementation for multi-process servers (DB, Redis, etc.).
- The SDK is REST-first; use the REST resource clients (e.g. `$api->product`) to call endpoints.
## Quick Start

### 1. Authentication Setup
```php
use JoonWeb\JoonWebAPI;

$auth_url = "https://accounts.joonweb.com/oauth/authorize?" . http_build_query([
    'client_id' => JOONWEB_CLIENT_ID,
    'scope' => 'read_products,write_products',
    'redirect_uri' => JOONWEB_REDIRECT_URI,
    'site' => $site_domain
]);

header("Location: " . $auth_url);
```

### 2. Handle OAuth Callback
```php
use JoonWeb\JoonWebAPI;

$joonweb = new JoonWebAPI();
$token_data = $joonweb->exchangeCodeForToken($_GET['code'], $_GET['site']);

$joonweb->setAccessToken($token_data['access_token'])
        ->setSiteDomain($_GET['site']);

$session->startSession($_GET['site'], $token_data);
header("Location: /embedded.php");
```

### 3. Use in Your App
```php
$api = new JoonWebAPI($access_token, $site_domain);

// Or configure later
$api = new JoonWebAPI();
$api->setAccessToken($token)
    ->setSiteDomain($site_domain);

```
## API Resources

### Products
```php
// Get all products
$products = $api->product->all(['limit' => 10]);

// Get single product
$product = $api->product->get(123);

// Create product
$new_product = $api->product->create([
    'title' => 'New Product',
    'price' => 29.99
]);

// Update product
$updated = $api->product->update(123, [
    'title' => 'Updated Product'
]);

// Count products
$count = $api->product->count();

### Orders
// Get all orders
$orders = $api->order->all(['status' => 'open', 'limit' => 50]);

// Get single order
$order = $api->order->get(456);

// Count orders
$order_count = $api->order->count(['status' => 'open']);
```
### Customers
```php
// Get all customers
$customers = $api->customer->all(['limit' => 50]);

// Get single customer
$customer = $api->customer->get(789);

### Webhooks
// Get all webhooks
$webhooks = $api->webhook->all();

// Create webhook
$webhook = $api->webhook->create([
    'topic' => 'orders/create',
    'address' => 'https://yourapp.com/webhooks/orders',
    'format' => 'json'
]);

// Delete webhook
$api->webhook->delete(111);
```
### Site Information
```php
// Get site details
$site = $api->site->get();
```

## Configuration

### Environment Variables
Set these in your .env file:
```env
APP_NAME="Your App Name"
JOONWEB_CLIENT_ID=your_client_id
JOONWEB_CLIENT_SECRET=your_client_secret
JOONWEB_REDIRECT_URI=https://yourapp.com/auth/callback.php
JOONWEB_API_VERSION=26.0
```

## Error Handling
All methods throw Exception on failure:
```php
try {
    $products = $api->product->all();
} catch (Exception $e) {
    error_log("API Error: " . $e->getMessage());
    // Handle error
}
```

## Webhook Verification
Verify incoming webhooks with HMAC:
```php
$hmac_header = $_SERVER['HTTP_X_JOONWEB_HMAC_SHA256'];
$payload = file_get_contents('php://input');
$calculated_hmac = base64_encode(hash_hmac('sha256', $payload, JOONWEB_CLIENT_SECRET, true));

if (hash_equals($hmac_header, $calculated_hmac)) {
    // Webhook is valid
    $data = json_decode($payload, true);
}
```
## Support
- Documentation: JoonWeb Developer Portal
- Issues: GitHub Issues
- Community: JoonWeb Developer Forum

## License
MIT License
