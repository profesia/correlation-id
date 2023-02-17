<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Generator;

use Ramsey\Uuid\Uuid;

final class Uuid4Generator implements CorrelationIdGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
