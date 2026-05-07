<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\BinService;
use App\DTO\CapturedRequest;
use Pusher\Pusher;

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

        $request = CapturedRequest::fromGlobals();

        $this->service->storeRequest($bin, $request);

        $options = [
            'useTLS' => false,
            'host' => 'soketi',
            'port' => 6001,
            'scheme' => 'http'
        ];

        $pusher = new Pusher('e79c5aff8362a28faddc6751086dbceb', 'dc98aabf44bf6711d4900a7a0df06cddd748b089eb9a4778cc165409b5615f0f', '3932a5aa-ee88-4bc5-a966-4952d9c22b86', $options);
        
        $pusher->trigger("bin-$bin", 'request.received', $request->toArray());

        return ["status" => "success"];
    }
}