<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Storage;

interface CorrelationIdStorageInterface
{
    public function store(string $key, string $value): void;
}
