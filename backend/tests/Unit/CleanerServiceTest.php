<?php

use App\Repositories\BinRepository;
use App\Services\CleanerService;

test('cleaner service triggers deleteExpired on repository', function () {
    $binRepo = Mockery::mock(BinRepository::class);
    $binRepo->shouldReceive('deleteExpired')->once();

    $cleaner = new CleanerService($binRepo);
    
    ob_start();
    $cleaner->run();
    $output = ob_get_clean();

    expect($output)->toContain('[Cleaner] executed at');
});