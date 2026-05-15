<?php

namespace App\Core\Contracts;

interface MiddlewareInterface
{
    public function handle(array $request, callable $next);
}