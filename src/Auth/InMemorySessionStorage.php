<?php
namespace JoonWeb\Auth;

/**
 * Very small in-memory session storage for local development and tests.
 * Not suitable for production but useful as a default so the library "just works".
 */
class InMemorySessionStorage implements SessionStorageInterface
{
    private array $store = [];

    public function store(string $id, array $payload): bool
    {
        $this->store[$id] = $payload;
        return true;
    }

    public function load(string $id): ?array
    {
        return $this->store[$id] ?? null;
    }

    public function delete(string $id): bool
    {
        if (isset($this->store[$id])) {
            unset($this->store[$id]);
            return true;
        }
        return false;
    }
}
