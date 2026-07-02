<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database
 * @package App\Core
 */
class Database
{
    /**
     * @var PDO|null
     */
    private static ?PDO $instance = null;

    /**
     * Database constructor.
     */
    private function __construct() {}

    /**
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // Fetch configuration from environment variables
            $host = 'db';
            $db   = 'users_manager_db';
            $user = 'db_admin';
            $pass = 'db_password';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Handle connection error
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
