<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Session
 * @package App\Core
 */
class Session
{
    /**
     * Start the session
     *
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a session variable
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session variable
     *
     * @param  string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    /**
     * Remove a session variable
     *
     * @param  string $key
     * @return void
     */
    public static function remove(string $key): void
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroy the session
     *
     * @return void
     */
    public static function destroy(): void
    {
        self::start();
        session_destroy();
    }

    /**
     * Generate a CSRF token
     *
     * @return string
     */
    public static function generateCsrfToken(): string
    {
        self::start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate a CSRF token
     *
     * @param  string|null $token
     * @return bool
     */
    public static function validateCsrfToken(?string $token): bool
    {
        self::start();
        if (!$token || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
