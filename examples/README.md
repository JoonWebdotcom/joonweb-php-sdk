# Examples

This folder contains minimal example files that show how to wire the `joonweb-php-sdk` into an application similar to `embed-app-php`.

Files
- `bootstrap.php` — minimal initialization (autoload + Context::init + session start).
- `auth/install.php` — redirect helper to start the OAuth install flow; call with `?site=your-site.myjoonweb.com`.
- `auth/callback.php` — example OAuth callback that exchanges the code for a token and persists it using the repository `SessionManager` (if present).
- `embedded.php` — minimal embedded page that reads the token/site from `SessionManager` and makes a simple API call.

Install the SDK into your app

Recommended (VCS): add the SDK repo as a VCS repository entry in your application's `composer.json` and require `joonweb/joonweb-sdk`.

Local development: use a `path` repository to symlink the local SDK for iterative development.

Quick local test

1. Add the SDK to your app via composer (path or vcs as above).
2. Ensure environment variables are set: `JOONWEB_CLIENT_ID`, `JOONWEB_CLIENT_SECRET`, `JOONWEB_REDIRECT_URI`, `JOONWEB_API_VERSION`.
3. Visit `examples/auth/install.php?site=your-site.myjoonweb.com` to start the install flow.

Notes
- These examples are intentionally minimal. Adjust error handling, session persistence and routing to match your application's patterns.
