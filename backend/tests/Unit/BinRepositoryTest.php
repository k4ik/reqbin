<?php

use App\Repositories\BinRepository;

beforeEach(function () {
    $this->repository = new BinRepository();
});

test('inserts and verifies bin existence', function () {
    $bin = 'test-bin-123';
    $expiresAt = time() + 3600;

    expect($this->repository->exists($bin))->toBeFalse();

    $this->repository->insert($bin, $expiresAt);

    expect($this->repository->exists($bin))->toBeTrue();
});

test('retrieves bin id by string key', function () {
    $bin = 'lookup-bin-key';
    $this->repository->insert($bin, time() + 3600);

    $id = $this->repository->getId($bin);

    expect($id)->toBeInt()->toBeGreaterThan(0);
});

test('returns null for nonexistent bin id lookup', function () {
    expect($this->repository->getId('non-existent'))->toBeNull();
});

test('deletes expired bins', function () {
    $pastTime = time() - 100;
    $futureTime = time() + 3600;

    $this->repository->insert('expired-bin', $pastTime);
    $this->repository->insert('valid-bin', $futureTime);

    $this->repository->deleteExpired();

    expect($this->repository->exists('expired-bin'))->toBeFalse()
        ->and($this->repository->exists('valid-bin'))->toBeTrue();
});

test('deletes specific bin', function () {
    $bin = 'delete-me';
    $this->repository->insert($bin, time() + 3600);

    $this->repository->delete($bin);

    expect($this->repository->exists($bin))->toBeFalse();
});