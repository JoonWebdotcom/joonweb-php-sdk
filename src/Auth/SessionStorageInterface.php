<?php
namespace JoonWeb\Auth;

/**
 * Minimal session storage interface used by the SDK.
 * Implement this interface to provide persistent session storage.
 */
interface SessionStorageInterface
{
    /**
     * Store a session payload keyed by id. Payload should be serializable.
     * @param string $id
     * @param array $payload
     * @return bool
     */
    public function store(string $id, array $payload): bool;

    /**
     * Load a session payload by id. Return null if not found.
     * @param string $id
     * @return null|array
     */
    public function load(string $id): ?array;

    /**
     * Delete a session record by id.
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool;
}
