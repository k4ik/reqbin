<?php declare(strict_types=1);

namespace App\Database;

use PDO;
use RuntimeException;

class Connection
{
    private static ?PDO $pdo = null;

    public static function get(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $dbPath = getenv('DB_PATH');

        if (!$dbPath) {
            throw new RuntimeException('DB_PATH not defined');
        }

        if (!file_exists($dbPath)) {
            touch($dbPath);
        }

        $pdo = new PDO('sqlite:' . $dbPath);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $pdo->exec('PRAGMA foreign_keys = ON');

        self::createTables($pdo);

        self::$pdo = $pdo;

        return $pdo;
    }

    private static function createTables(PDO $pdo): void
    {
        $sql = '
            CREATE TABLE IF NOT EXISTS bins (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                bin TEXT NOT NULL UNIQUE,
                created_at INTEGER NOT NULL,
                expires_at INTEGER NOT NULL
            );

            CREATE TABLE IF NOT EXISTS requests (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                bin_id INTEGER NOT NULL,
                method TEXT NOT NULL,
                headers TEXT NOT NULL,
                body TEXT,
                query_params TEXT,
                ip TEXT NOT NULL,
                created_at INTEGER NOT NULL,
                FOREIGN KEY (bin_id) REFERENCES bins(id) ON DELETE CASCADE
            );

            CREATE INDEX IF NOT EXISTS idx_requests_bin_id ON requests(bin_id);
        ';

        $pdo->exec($sql);
    }
}