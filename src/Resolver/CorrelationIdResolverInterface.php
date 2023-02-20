<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Resolver;

interface CorrelationIdResolverInterface
{
    public function resolve(): string;

    public function store(?string $value = null): void;
}
