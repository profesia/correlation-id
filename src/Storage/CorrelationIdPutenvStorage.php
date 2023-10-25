<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Storage;

class CorrelationIdPutenvStorage implements CorrelationIdStorageInterface
{
    public function store(string $key, string $value): void
    {
        putenv("$key=$value");
    }

    public function read(string $key): ?string
    {
        $value = getenv($key, true);
        if ($value === '' || $value === false || $value === []) {
            return null;
        }

        return $value;
    }
}
