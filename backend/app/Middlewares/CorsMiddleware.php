<?php

namespace App\Middlewares;

use App\Core\Contracts\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function handle(array $request, callable $next)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        if ($request['method'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        return $next($request);
    }
}