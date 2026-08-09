<?php

use App\DTO\CapturedRequest;
use App\Repositories\BinRepository;
use App\Repositories\RequestRepository;
use App\Services\BinService;

beforeEach(function () {
    $this->binRepo = Mockery::mock(BinRepository::class);
    $this->requestRepo = Mockery::mock(RequestRepository::class);
    $this->service = new BinService($this->binRepo, $this->requestRepo);
});

test('creates a bin successfully', function () {
    $this->binRepo->shouldReceive('exists')->andReturn(false);
    $this->binRepo->shouldReceive('insert')->once()->with(Mockery::type('string'), Mockery::type('int'));

    $bin = $this->service->createBin();

    expect($bin)->toBeString()->toHaveLength(30);
});

test('stores captured request for valid bin', function () {
    $bin = 'valid-bin';
    $capturedRequest = new CapturedRequest(
        'POST',
        ['Content-Type' => 'application/json'],
        '{"foo":"bar"}',
        ['param' => 'value'],
        time(),         
        '127.0.0.1'      
    );

    $this->binRepo->shouldReceive('getId')->with($bin)->andReturn(1);
    $this->requestRepo->shouldReceive('insert')->once()->with(1, $capturedRequest);

    $this->service->storeRequest($bin, $capturedRequest);
});

test('throws exception when storing request for nonexistent bin', function () {
    $bin = 'missing-bin';
    $capturedRequest = new CapturedRequest(
        'GET',
        [],
        '',             
        [],
        time(),          
        '127.0.0.1'      
    );

    $this->binRepo->shouldReceive('getId')->with($bin)->andReturn(null);

    expect(fn () => $this->service->storeRequest($bin, $capturedRequest))
        ->toThrow(RuntimeException::class, 'Bin not found');
});

test('gets requests for valid bin', function () {
    $bin = 'valid-bin';
    $expected = [['id' => 1, 'method' => 'GET']];

    $this->binRepo->shouldReceive('getId')->with($bin)->andReturn(10);
    $this->requestRepo->shouldReceive('getByBin')->with(10)->andReturn($expected);

    $result = $this->service->getRequests($bin);

    expect($result)->toBe($expected);
});