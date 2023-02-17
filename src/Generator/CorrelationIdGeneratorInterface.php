<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Generator;

interface CorrelationIdGeneratorInterface
{
    public function generate(): string;
}
