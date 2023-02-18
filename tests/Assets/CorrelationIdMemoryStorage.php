<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Assets;

use Profesia\CorrelationId\Storage\CorrelationIdStorageInterface;

class CorrelationIdMemoryStorage implements CorrelationIdStorageInterface
{
    private array $data = [];

    public function store(string $key, string $value): void
    {
        $this->data[$key] = $value;
    }

    public function read(string $key): ?string
    {
        if (array_key_exists($key, $this->data) === false) {
            return null;
        }

        return $this->data[$key];
    }

}
