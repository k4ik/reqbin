<?php declare(strict_types=1);

namespace App\Controllers;

use App\DTO\CapturedRequest;
use App\Services\BinService;

class BinController
{
    private BinService $service;

    public function __construct(BinService $service)
    {
        $this->service = $service;
    }

    public function createBin(): string
    {
        return $this->service->createBin();
    }

    public function getRequests(string $bin): array 
    {
        $id = $this->service->getBinId($bin);
        return $this->service->getRequests($id);
    } 

    public function handleRequest(string $binId): array
    {
        if (!$this->service->exists($binId)) {
            http_response_code(404);
            return ['error' => 'Bin not found'];
        }

        $request = CapturedRequest::fromGlobals();

        $this->service->storeRequest($binId, $request);

        return $request->toArray();
    }
}
