<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Services\CleanerService;

$worker = new CleanerService();
$worker->run();