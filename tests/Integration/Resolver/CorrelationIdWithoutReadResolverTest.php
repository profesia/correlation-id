<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Integration\Resolver;

use PHPUnit\Framework\TestCase;
use Profesia\CorrelationId\Resolver\CorrelationIdWithoutReadResolver;
use Profesia\CorrelationId\Test\Assets\CorrelationIdMemoryStorage;
use Profesia\CorrelationId\Test\Assets\TestUuidGenerator;

class CorrelationIdWithoutReadResolverTest extends TestCase
{

    public function testCanGenerateId(): void
    {
        $key      = 'empty-string';
        $resolver = new CorrelationIdWithoutReadResolver(
            new TestUuidGenerator(),
            new CorrelationIdMemoryStorage(),
            $key
        );

        $resolvedId = $resolver->resolve();
        $this->assertEquals(TestUuidGenerator::VALUE, $resolvedId);
    }

    public function testCanStoreGeneratedIdIntoServer(): void
    {
        $storage   = new CorrelationIdMemoryStorage();
        $generator = new TestUuidGenerator();
        $resolver  = new CorrelationIdWithoutReadResolver(
            $generator,
            $storage,
            'test'
        );

        $this->assertEquals(null, $storage->read('test'));
        $resolver->store('test');
        $this->assertEquals('test', $storage->read('test'));
    }
}