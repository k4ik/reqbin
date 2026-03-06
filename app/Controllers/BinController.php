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

    public function createBin(): array
    {
        $bin = $this->service->createBin();

        return [
            'bin' => $bin
        ];
    }

    public function getRequests(string $bin): array
    {
        if (!$this->service->exists($bin)) {
            http_response_code(404);
            return ['error' => 'Bin not found'];
        }
        $id = $this->service->getBinId($bin);
        return $this->service->getRequests($id);
    }

    public function handleRequest(string $bin): array
    {
        if (!$this->service->exists($bin)) {
            http_response_code(404);
            return ['error' => 'Bin not found'];
        }

        if ($this->service->isExpired($bin)) {
            $this->service->deleteBin($bin);

            http_response_code(410);
            return ['error' => 'Bin expired'];
        }

        $request = CapturedRequest::fromGlobals();

        $this->service->storeRequest($bin, $request);

        return $request->toArray();
    }
}
