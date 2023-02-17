<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Storage;

class CorrelationIdEnvironmentStorage implements CorrelationIdStorageInterface
{
    public function store(string $key, string $value): void
    {
        putenv("$key=$value");
    }
}
