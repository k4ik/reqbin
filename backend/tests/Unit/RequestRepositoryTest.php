<?php

use App\DTO\CapturedRequest;
use App\Repositories\BinRepository;
use App\Repositories\RequestRepository;

beforeEach(function () {
    $this->binRepo = new BinRepository();
    $this->requestRepo = new RequestRepository();

    $this->binRepo->insert('test-bin', time() + 3600);
    $this->binId = $this->binRepo->getId('test-bin');
});

test('inserts and fetches captured requests for a bin', function () {
    $capturedRequest = new CapturedRequest(
        'POST',
        ['Content-Type' => 'application/json'],
        '{"foo":"bar"}',
        ['param' => 'value'],
        time(),          
        '127.0.0.1'      
    );

    $this->requestRepo->insert($this->binId, $capturedRequest);

    $requests = $this->requestRepo->getByBin($this->binId);

    expect($requests)->toHaveCount(1)
        ->and($requests[0]['method'])->toBe('POST')
        ->and($requests[0]['ip'])->toBe('127.0.0.1');
});