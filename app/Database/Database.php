<?php declare(strict_types=1);

namespace App\Database;

use PDO;
use App\DTO\CapturedRequest;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $dbPath = getenv('DB_PATH');

        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('PRAGMA foreign_keys = ON');

        $this->createTables();
    }

    private function createTables(): void
    {
        $sql = '
            CREATE TABLE IF NOT EXISTS bins (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                bin TEXT NOT NULL UNIQUE,
                created_at INTEGER NOT NULL
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

        $this->pdo->exec($sql);
    }

    public function exists(string $bin): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM bins WHERE bin = :bin LIMIT 1'
        );

        $stmt->execute([
            ':bin' => $bin
        ]);

        return $stmt->fetch() !== false;
    }

    public function insert(string $bin): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO bins (bin, created_at) VALUES (:bin, :created_at)'
        );

        $stmt->execute([
            ':bin' => $bin,
            ':created_at' => time()
        ]);
    }

    public function delete(string $bin): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM bins WHERE bin = :bin'
        );

        $stmt->execute([
            ':bin' => $bin
        ]);
    }

    public function getRequests(int $binId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, method, headers, body, query_params, ip, created_at FROM requests WHERE bin_id = :id ORDER BY created_at DESC'
        );

        $stmt->execute([
            ':id' => $binId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBinId(string $bin): ?int
    {
        $stmt = $this->pdo->prepare(
            'SELECT id FROM bins WHERE bin = :bin LIMIT 1'
        );

        $stmt->execute([
            ':bin' => $bin
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['id'] : null;
    }

    public function insertRequest(int $binId, CapturedRequest $request): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO requests 
        (bin_id, method, headers, body, query_params, ip, created_at)
        VALUES 
        (:bin_id, :method, :headers, :body, :query_params, :ip, :created_at)'
        );

        $stmt->execute([
            ':bin_id' => $binId,
            ':method' => $request->method(),
            ':headers' => json_encode($request->headers(), JSON_THROW_ON_ERROR),
            ':body' => $request->body(),
            ':query_params' => json_encode($request->query(), JSON_THROW_ON_ERROR),
            ':ip' => $request->ip(),
            ':created_at' => $request->timestamp(),
        ]);
    }
}
