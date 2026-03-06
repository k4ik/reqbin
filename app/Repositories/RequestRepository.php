<?php declare(strict_types=1);

namespace App\Repositories;

use App\Database\Connection;
use App\DTO\CapturedRequest;
use PDO;

class RequestRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function insert(int $binId, CapturedRequest $request): void
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

    public function getByBin(int $binId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, method, headers, body, query_params, ip, created_at
             FROM requests
             WHERE bin_id = :id
             ORDER BY created_at DESC'
        );

        $stmt->execute([':id' => $binId]);

        return $stmt->fetchAll();
    }
}