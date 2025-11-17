## Quick orientation

This repository is a small PHP SDK that wraps the JoonWeb platform REST API. Key entry points:
- `src/JoonWebAPI.php` — high-level facade that instantiates resource clients (product, order, webhook, site).
- `src/Clients/BaseClient.php` — shared HTTP client using curl; resource classes extend this and call `request()`.
- `src/Resources/*.php` — each resource (Product, Order, Webhook, Site) maps to REST endpoints and JSON payloads.
- `src/Auth/` — authentication/session helpers; this subpackage uses stricter typing and encapsulates OAuth/session logic.

The project uses PSR-4 autoloading (`JoonWeb\` → `src/`) and relies on a few global constants (see README):
- `JOONWEB_CLIENT_ID`, `JOONWEB_CLIENT_SECRET`, `JOONWEB_API_VERSION`, `APP_NAME`, `APP_VERSION`.

## Big picture architecture & why it matters

- Thin SDK wrapper: each Resource class only transforms calls into HTTP requests to `https://{site}/api/admin/{version}/*` and returns decoded JSON. Keep changes small and localized to resources.
- Shared HTTP behavior (headers, error mapping, timeouts) lives in `BaseClient`. If you need retry, logging, or different HTTP adapter, replace/extend `BaseClient` rather than changing each resource.
- Auth is split: `src/JoonWebAPI.php` is a convenience facade for callers; `src/Auth/` handles OAuth/session semantics (cookie and JWT handling). Changes to OAuth flows should be made inside `src/Auth` to avoid surprising side effects.

## Repo-specific conventions and patterns

- Namespaces: `JoonWeb\` root mirrors `src/` (PSR-4). Add files under `src/` with matching namespaces.
- Resource shape: resource methods accept arrays and return decoded JSON arrays (no DTOs). Example: `Product::create(['title'=>...])` calls `POST /products.json` with `['product'=> $data]`.
- Endpoints use `.json` suffix (e.g. `/products.json`, `/products/count.json`). Follow this pattern when adding new endpoints.
- HTTP: raw cURL calls are used in `BaseClient` and `JoonWebAPI::exchangeCodeForToken`. If you introduce Guzzle or another adapter, modify `BaseClient` and keep the public resource methods unchanged.
- Error handling: `BaseClient::request()` throws generic Exceptions for HTTP >= 400. Tests and consumer code expect exceptions for error cases.

## Authentication & sessions (important)

- OAuth token exchange occurs in `JoonWebAPI::exchangeCodeForToken()` (sends JSON payload to `/oauth/access_token`). Keep that flow consistent with README examples.
- `src/Auth/` contains more robust session management (cookie signing, JWT handling). Embedded apps and server-to-server flows are distinguished — check `Context::$IS_EMBEDDED_APP` usages.
- Session storage is pluggable through the `Context::$SESSION_STORAGE` used by the `Auth` classes. When modifying session behavior, ensure tests simulate both embedded and non-embedded flows.

## How to add a new Resource (example)

1. Create `src/Resources/YourResource.php` with namespace `JoonWeb\Resources` and extend `JoonWeb\Clients\BaseClient`.
2. Implement thin methods that call `$this->request('/your_endpoint.json', 'GET|POST|PUT|DELETE', $data)`.
3. Register it on the facade: add a public property to `JoonWebAPI` and instantiate it in the constructor, passing the access token and site domain (see `JoonWebAPI::__construct`).

Example snippet (existing pattern):

    // src/Resources/Product.php -> public function create($data) { return $this->request('/products.json','POST',['product'=>$data]); }

## Tests, build, and developer commands

- Unit tests: `phpunit` (dev dependency). Composer scripts:
  - `composer test` runs tests (configured in composer.json)
  - `composer test-coverage` generates HTML coverage
- When changing request behavior, run `composer test` to validate no regressions.

## Integration points & environment

- The SDK expects global constants or environment-provided values for credentials and API version. These are documented in `README.md`. Typical bootstrap defines these constants from env variables.
- The runtime communicates directly with the JoonWeb site via HTTPS and the `/api/admin/{version}/...` endpoints; tests may mock HTTP responses — prefer changing mocks in tests rather than hitting live servers.

## Quick bootstrap (framework-agnostic example)

Add a tiny bootstrap before using the SDK in your app. This example shows how to initialize the context and set a persistent session store (optional):

```php
require 'vendor/autoload.php';
use JoonWeb\Context;
use JoonWeb\Auth\SessionManager; // the repo provides a SessionManager; replace with your own persistent storage if needed

Context::init([
  'api_key' => getenv('JOONWEB_CLIENT_ID'),
  'api_secret' => getenv('JOONWEB_CLIENT_SECRET'),
  'api_version' => getenv('JOONWEB_API_VERSION') ?: '26.0',
  'is_embedded' => false,
  // Optional: provide your own session storage implementation. By default the repo's SessionManager will be used if present.
  // 'session_storage' => new SessionManager(),
]);

$api = new JoonWeb\JoonWebAPI();
$api->setAccessToken(
  /* access token from your session or OAuth flow */
);
$api->setSiteDomain('example.myjoonweb.com');
```

Notes:
- Replace `InMemorySessionStorage` with a persistent implementation for multi-process servers (DB, Redis, etc.).
 - Replace `InMemorySessionStorage` with a persistent implementation for multi-process servers (DB, Redis, etc.).
 - The SDK is REST-first; GraphQL support is intentionally omitted by default. Use the REST resource clients (e.g. `$api->product`) to call endpoints.

## Files to inspect for context (quick list)

- `composer.json` — dependencies and test scripts
- `README.md` — usage examples and env vars
- `src/JoonWebAPI.php` — facade wiring for resources
- `src/Clients/BaseClient.php` — central HTTP behavior
- `src/Resources/*` — resource implementations
- `src/Auth/*` — OAuth/session implementation and helpers

## What an AI assistant should do (practical guidance)

- Make minimal, localized edits: prefer adding new resource classes or changing `BaseClient` rather than sweeping changes across many files.
- When changing HTTP behavior, run tests and update resource-level expectations.
- Preserve existing error signatures (exceptions thrown by `BaseClient`) to avoid breaking consumers.
- When modifying auth/session code, run the OAuth-related unit tests and verify cookie/JWT flows; check both embedded and non-embedded branches.

## Questions for the maintainer / next actions

- Are the global constants (APP_NAME, APP_VERSION, JOONWEB_* ) defined in a recommended bootstrap file or left to integrators? If there is a preferred bootstrap, point to it so examples can be updated.
- Is there an expectation to migrate cURL → PSR-18 / HTTP client abstraction in the near future?

If anything here is unclear or you'd like the file expanded with quick code examples or tests, tell me what to add and I will iterate.
