<?php declare(strict_types=1);

namespace App\Services;

use App\Database\Database;
use App\DTO\CapturedRequest;

class BinService
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function generateBinId(int $length = 30): string
    {
        $chars = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        $id = '';

        for ($i = 0; $i < $length; $i++) {
            $id .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $id;
    }

    public function createBin(): string
    {
        do {
            $bin = $this->generateBinId();
        } while ($this->exists($bin));

        $this->db->insert($bin);

        return $bin;
    }

    public function storeRequest(string $bin, CapturedRequest $request): void
    {
        $binId = $this->db->getBinId($bin);

        if ($binId === null) {
            throw new \RuntimeException('Bin not found');
        }

        $this->db->insertRequest($binId, $request);
    }

    public function deleteBin(string $bin): void
    {
        $this->db->delete($bin);
    }

    public function exists(string $bin): bool
    {
        return $this->db->exists($bin);
    }

    public function getBinId(string $bin): int 
    {
        return $this->db->getBinId($bin);
    }

    public function getRequests(int $id): array 
    {
        return $this->db->getRequests($id);
    }
}
