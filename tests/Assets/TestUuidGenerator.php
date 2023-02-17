<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Assets;

use Profesia\CorrelationId\Generator\CorrelationIdGeneratorInterface;

class TestUuidGenerator implements CorrelationIdGeneratorInterface
{
    public const VALUE = '7e8e94e2-bf74-4a52-a6de-5d33a8bd0836';

    public function generate(): string
    {
        return self::VALUE;
    }
}
