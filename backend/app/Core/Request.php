<?php

namespace App\Core;

class Request
{
    public string $method;
    public string $path;
    public string $ip;
    public array $headers;
    public string $body;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        $this->ip = $_SERVER['REMOTE_ADDR'];

        $this->headers = getallheaders();

        $this->body = file_get_contents('php://input');
    }
}