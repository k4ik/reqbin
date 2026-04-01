<?php declare(strict_types=1);

namespace App\DTO;

final class CapturedRequest
{
    public function __construct(
        private readonly string $method,
        private readonly array $headers,
        private readonly string $body,
        private readonly array $query_params,
        private readonly int $timestamp,
        private readonly string $ip,
    ) {}

    public static function fromGlobals(): self
    {
        return new self(
            method: $_SERVER['REQUEST_METHOD'] ?? 'GET',
            headers: function_exists('getallheaders') ? getallheaders() : [],
            body: file_get_contents('php://input') ?: '',
            query_params: $_GET ?? [],
            timestamp: time(),
            ip: $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function query(): array
    {
        return $this->query_params;
    }

    public function timestamp(): int
    {
        return $this->timestamp;
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function toArray(): array
    {
        return [
            'method' => $this->method,
            'headers' => $this->headers,
            'body' => $this->body,
            'query_params' => $this->query_params,
            'timestamp' => $this->timestamp,
            'ip' => $this->ip,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}