<?php

declare(strict_types=1);

namespace Profesia\CorrelatioId\Test\Integration;

use PHPUnit\Framework\TestCase;
use Profesia\CorrelationId\Generator\Uuid4Generator;
use Ramsey\Uuid\Rfc4122\UuidV4;

class Uuid4GeneratorTest extends TestCase
{
    public function testCanGenerate(): void
    {
        $generator = new Uuid4Generator();
        $generatedValue = $generator->generate();

        $uuid = UuidV4::fromString($generatedValue);
        $this->assertEquals(4, $uuid->getVersion());
    }
}
