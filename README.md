# Joonweb PHP SDK

A professional, PSR-4 compliant PHP SDK for integrating with the Joonweb Admin API.

## Installation

```bash
composer require joonweb/joonweb-sdk
```

## Quick Start

### 1. Initialization

Initialize the global SDK context with your app credentials. This ensures your keys are securely managed.

```php
use JoonWeb\Context;

Context::init([
    'api_key' => getenv('JOONWEB_CLIENT_ID'),
    'api_secret' => getenv('JOONWEB_CLIENT_SECRET'),
    'api_version' => '26.0',
    'app_name' => 'My Joonweb App'
]);
```

### 2. OAuth Authentication

Redirect the user to Joonweb to approve your app:
```php
use JoonWeb\Auth\OAuth;

$auth_url = OAuth::getAuthorizationUrl('example.myjoonweb.com', ['read_products', 'write_products'], 'https://yourapp.com/callback');
header("Location: " . $auth_url);
```

Exchange the code for a token:
```php
$tokenData = OAuth::exchangeCodeForToken('example.myjoonweb.com', $_GET['code']);
$accessToken = $tokenData['access_token'];
```

### 3. Making API Calls

```php
use JoonWeb\JoonWebAPI;

// Initialize the client
$api = new JoonWebAPI($accessToken, 'example.myjoonweb.com');

// Get all products
$products = $api->product->all(['limit' => 10]);

// Create a new product
$newProduct = $api->product->create([
    'title' => 'Awesome Shirt',
    'price' => 19.99
]);

// Update a custom collection
$api->collection->update(123, ['title' => 'Updated Title']);
```

### 4. Verifying Webhooks

```php
use JoonWeb\Auth\OAuth;

$payload = file_get_contents('php://input');
$hmac = $_SERVER['HTTP_X_JOONWEB_HMAC_SHA256'];

if (OAuth::verifyWebhook($payload, $hmac)) {
    // Valid webhook
}
```
