<?php
declare(strict_types=1);

namespace App\Service\Jwt;

class Payload
{
    public function __construct(private object $data)
    {
    }

    public function get(string $key): mixed
    {
        return property_exists($this->data, $key) ? $this->data->{$key} : null;
    }

    public function check(string $key, mixed $expected): bool
    {
        return $this->get($key) === $expected;
    }
}