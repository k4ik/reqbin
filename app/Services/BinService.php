<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\BinRepository;
use App\Repositories\RequestRepository;
use App\DTO\CapturedRequest;

class BinService
{
    private BinRepository $bins;
    private RequestRepository $requests;

    public function __construct()
    {
        $this->bins = new BinRepository();
        $this->requests = new RequestRepository();
    }

    public function createBin(): string
    {
        do {
            $bin = $this->generateId();
        } while ($this->bins->exists($bin));

        $this->bins->insert($bin, time() + 86400);

        return $bin;
    }

    public function storeRequest(string $bin, CapturedRequest $request): void
    {
        $binId = $this->bins->getId($bin);

        if ($binId === null) {
            throw new \RuntimeException('Bin not found');
        }

        $this->requests->insert($binId, $request);
    }

    public function getRequests(string $bin): array
    {
        $id = $this->bins->getId($bin);

        if ($id === null) {
            throw new \RuntimeException('Bin not found');
        }

        return $this->requests->getByBin($id);
    }

    public function exists(string $bin): bool
    {
        return $this->bins->exists($bin);
    }

    public function isExpired(string $bin): bool
    {
        return $this->bins->expired($bin);
    }

    public function delete(string $bin): void
    {
        $this->bins->delete($bin);
    }

    private function generateId(int $length = 30): string
    {
        $chars = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';

        $id = '';

        for ($i = 0; $i < $length; $i++) {
            $id .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $id;
    }
}