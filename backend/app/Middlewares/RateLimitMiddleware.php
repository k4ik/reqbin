<?php

namespace App\Middlewares;

use App\Core\Response;
use App\Core\Contracts\MiddlewareInterface;
use Predis\Client;

class RateLimitMiddleware implements MiddlewareInterface
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host'   => $_ENV['REDIS_HOST'] ?? 'redis',
            'port'   => $_ENV['REDIS_PORT'] ?? 6379,
        ]);
    }

    public function handle(array $request, callable $next)
    {
        $ip = $request['ip'];

        $key = "rate_limit:$ip";

        $limit = 100;
        $window = 60;

        $requests = $this->redis->incr($key);

        if ($requests === 1) {
            $this->redis->expire($key, $window);
        }

        if ($requests > $limit) {
            Response::json([
                'error' => 'Too many requests'
            ], 429);
        }

        header("X-RateLimit-Limit: $limit");
        header(
            "X-RateLimit-Remaining: " .
            max(0, $limit - $requests)
        );

        return $next($request);
    }
}