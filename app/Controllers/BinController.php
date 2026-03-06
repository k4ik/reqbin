<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\BinService;
use App\DTO\CapturedRequest;

class BinController
{
    private BinService $service;

    public function __construct(BinService $service)
    {
        $this->service = $service;
    }

    public function createBin(): array
    {
        return [
            'bin' => $this->service->createBin()
        ];
    }

    public function getRequests(string $bin): array
    {
        if (!$this->service->exists($bin)) {
            http_response_code(404);
            return ['error' => 'Bin not found'];
        }

        return $this->service->getRequests($bin);
    }

    public function handleRequest(string $bin): array
    {
        if (!$this->service->exists($bin)) {
            http_response_code(404);
            return ['error' => 'Bin not found'];
        }

        if ($this->service->isExpired($bin)) {
            $this->service->delete($bin);

            http_response_code(410);
            return ['error' => 'Bin expired'];
        }

        $request = CapturedRequest::fromGlobals();

        $this->service->storeRequest($bin, $request);

        return $request->toArray();
    }
}