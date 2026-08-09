<?php

use App\Controllers\BinController;
use App\Services\BinService;
use App\Services\BroadcasterService;

beforeEach(function () {
    $this->binService = Mockery::mock(BinService::class);
    $this->broadcaster = Mockery::mock(BroadcasterService::class);
    $this->controller = new BinController($this->binService, $this->broadcaster);
});

test('createBin returns structured bin response', function () {
    $this->binService->shouldReceive('createBin')->andReturn('generated-bin-id');

    $response = $this->controller->createBin();

    expect($response)->toBe(['bin' => 'generated-bin-id']);
});

test('getRequests returns 404 when bin does not exist', function () {
    $this->binService->shouldReceive('exists')->with('invalid-bin')->andReturn(false);

    $response = $this->controller->getRequests('invalid-bin');

    expect($response)->toBe(['error' => 'Bin not found'])
        ->and(http_response_code())->toBe(404);
});

test('getRequests returns requests payload for existing bin', function () {
    $requestsPayload = [['id' => 1, 'method' => 'POST']];

    $this->binService->shouldReceive('exists')->with('valid-bin')->andReturn(true);
    $this->binService->shouldReceive('getRequests')->with('valid-bin')->andReturn($requestsPayload);

    $response = $this->controller->getRequests('valid-bin');

    expect($response)->toBe($requestsPayload);
});