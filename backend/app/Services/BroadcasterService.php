<?php declare(strict_types=1);

namespace App\Services;

use Pusher\Pusher;

class BroadcasterService
{
    private Pusher $pusher;

    public function __construct()
    {
        $options = [
            'useTLS' => getenv('SOKETI_USE_TLS') === 'true',
            'host' => getenv('SOKETI_HOST') ?: 'soketi',
            'port' => (int)(getenv('SOKETI_PORT') ?: 6001),
            'scheme' => getenv('SOKETI_SCHEME') ?: 'http'
        ];

        $this->pusher = new Pusher(
            getenv('SOKETI_DEFAULT_APP_KEY') ?: '',
            getenv('SOKETI_DEFAULT_APP_SECRET') ?: '',
            getenv('SOKETI_DEFAULT_APP_ID') ?: '',
            $options
        );
    }

    public function broadcast(string $channel, string $event, array $data): void
    {
        $this->pusher->trigger($channel, $event, $data);
    }
}