<?php declare(strict_types=1);

namespace App\Repositories;

use App\Database\Connection;
use PDO;

class BinRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function insert(string $bin, int $expiresAt): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO bins (bin, created_at, expires_at)
             VALUES (:bin, :created_at, :expires_at)'
        );

        $stmt->execute([
            ':bin' => $bin,
            ':created_at' => time(),
            ':expires_at' => $expiresAt
        ]);
    }

    public function exists(string $bin): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM bins WHERE bin = :bin LIMIT 1'
        );

        $stmt->execute([':bin' => $bin]);

        return $stmt->fetch() !== false;
    }

    public function expired(string $bin): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM bins
             WHERE bin = :bin AND expires_at < :now
             LIMIT 1'
        );

        $stmt->execute([
            ':bin' => $bin,
            ':now' => time()
        ]);

        return $stmt->fetch() !== false;
    }

    public function delete(string $bin): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM bins WHERE bin = :bin'
        );

        $stmt->execute([':bin' => $bin]);
    }

    public function getId(string $bin): ?int
    {
        $stmt = $this->pdo->prepare(
            'SELECT id FROM bins WHERE bin = :bin LIMIT 1'
        );

        $stmt->execute([':bin' => $bin]);

        $row = $stmt->fetch();

        return $row ? (int) $row['id'] : null;
    }
}