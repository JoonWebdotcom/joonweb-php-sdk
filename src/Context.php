<?php
namespace JoonWeb;

/**
 * Lightweight runtime Context used by Auth and clients.
 *
 * This class is intentionally small and meant to be initialized by the
 * embedding application. It provides defaults that make the SDK usable
 * without a framework, but these values should be overridden in production.
 */
class Context
{
    public static ?string $API_KEY = null;
    public static ?string $API_SECRET_KEY = null;
    public static string $API_VERSION = '26.0';
    public static bool $IS_EMBEDDED_APP = true;

    /**
     * Session storage implementation. The SDK provides a default in-memory
     * adapter but apps should replace this with a persistent implementation
     * (database, Redis, filesystem) in production via init().
     */
    public static $SESSION_STORAGE = null;

    public static function init(array $options = [])
    {
        self::$API_KEY = $options['api_key'] ?? self::$API_KEY;
        self::$API_SECRET_KEY = $options['api_secret'] ?? self::$API_SECRET_KEY;
        self::$API_VERSION = $options['api_version'] ?? self::$API_VERSION;
        self::$IS_EMBEDDED_APP = $options['is_embedded'] ?? self::$IS_EMBEDDED_APP;

        if (isset($options['session_storage'])) {
            self::$SESSION_STORAGE = $options['session_storage'];
        } elseif (self::$SESSION_STORAGE === null) {
            // Prefer an existing project-provided session manager if present.
            if (class_exists('\JoonWeb\\Auth\\SessionManager')) {
                self::$SESSION_STORAGE = new \JoonWeb\Auth\SessionManager();
            } else {
                // Leave null — embedding app should provide a session storage implementation.
                self::$SESSION_STORAGE = null;
            }
        }
    }

    public static function throwIfUninitialized(): void
    {
        if (!self::$API_KEY || !self::$API_SECRET_KEY) {
            throw new \Exception('Context not initialized. Call Context::init() with api_key and api_secret.');
        }
    }

    public static function throwIfPrivateApp(string $message = ''): void
    {
        // Default: nothing special for private apps here. Kept for compatibility with Auth::calls.
        return;
    }
}
