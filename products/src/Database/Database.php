<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private static $pdo;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                $host = getenv('DB_HOST') ?: 'localhost'; // Fallback to default values if not set
                $dbname = getenv('DB_NAME') ?: 'myapp_db';
                $user = getenv('DB_USER') ?: 'root';
                $pass = getenv('DB_PASS') ?: '';

                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
