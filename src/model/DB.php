<?php

declare(strict_types=1);

class DB
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT') ?: '3306';
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            if (!$host || !$dbname || !$user) {
                throw new RuntimeException('Database configuration environment variables are missing.');
            }

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                error_log('Database connection failed: ' . $e->getMessage());
                throw new RuntimeException('Could not connect to the database.');
            }
        }
        return self::$pdo;
    }
}
