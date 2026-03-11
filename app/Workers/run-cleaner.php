<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Service\CleanerService;

$worker = new CleanerService();
$worker->run();