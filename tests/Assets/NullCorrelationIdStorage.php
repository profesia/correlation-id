<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Assets;

use Profesia\CorrelationId\Storage\CorrelationIdStorageInterface;

class NullCorrelationIdStorage implements CorrelationIdStorageInterface
{
    public function store(string $key, string $value): void
    {
        putenv("$key=$value");
    }
}
