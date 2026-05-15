<?php

namespace App\Core;

class Pipeline
{
    private array $middlewares = [];

    public function pipe($middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function process(array $request, callable $destination)
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            fn ($next, $middleware) =>
                fn ($request) =>
                    $middleware->handle($request, $next),
            $destination
        );

        return $pipeline($request);
    }
}