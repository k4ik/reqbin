<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\BinService;
use App\Services\BroadcasterService;
use App\DTO\CapturedRequest;

class BinController
{
    private BinService $service;
    private BroadcasterService $broadcaster;

    public function __construct(BinService $service, BroadcasterService $broadcaster)
    {
        $this->service = $service;
        $this->broadcaster = $broadcaster;
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

        $request = CapturedRequest::fromGlobals();

        $this->service->storeRequest($bin, $request);

        $this->broadcaster->broadcast("bin-$bin", 'request.received', $request->toArray());

        return ["status" => "success"];
    }
}