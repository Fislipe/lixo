<?php
namespace App\Database;

use PDO;

class Conexao
{
    private static ?PDO $pdo = null;

    public static function get(): PDO
    {
        if (self::$pdo === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $database = getenv('DB_NAME') ?: 'loja';
            $user = getenv('DB_USER') ?: 'loja';
            $password = getenv('DB_PASSWORD') ?: 'loja';

            self::$pdo = new PDO(
                "mysql:host={$host};dbname={$database};charset=utf8mb4",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }

        return self::$pdo;
    }
}
