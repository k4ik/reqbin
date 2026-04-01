<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\BinRepository;

class CleanerService
{
    private BinRepository $bins;

    public function __construct()
    {
        $this->bins = new BinRepository;
    }

    public function run(): void
    {
        while (true) {
            $this->bins->deleteExpired();
            echo '[Cleaner] executed at ' . date('Y-m-d H:i:s') . PHP_EOL;
            sleep(1800);
        }
    }
}
