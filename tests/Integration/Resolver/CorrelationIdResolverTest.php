<?php

declare(strict_types=1);

namespace Profesia\CorrelatioId\Test\Integration\Resolver;

use PHPUnit\Framework\TestCase;
use Profesia\CorrelationId\Resolver\CorrelationIdResolver;
use Profesia\CorrelationId\Test\Assets\CorrelationIdMemoryStorage;
use Profesia\CorrelationId\Test\Assets\TestUuidGenerator;

class CorrelationIdResolverTest extends TestCase
{
    public function testCanResolveIdFromEnvironmentParam(): void
    {
        $key     = 'key';
        $storage = new CorrelationIdMemoryStorage();
        $storage->store($key, $key);

        $resolver = new CorrelationIdResolver(
            new TestUuidGenerator(),
            $storage,
            $key
        );

        $resolvedId = $resolver->resolve();
        $this->assertEquals($key, $resolvedId);
    }

    public function testCanGenerateIdWhenEnvIdIsNotSet(): void
    {
        $key      = 'empty-string';
        $resolver = new CorrelationIdResolver(
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
        $resolver  = new CorrelationIdResolver(
            $generator,
            $storage,
            'test'
        );

        $this->assertEquals(null, $storage->read('test'));
        $resolver->store('test');
        $this->assertEquals('test', $storage->read('test'));
    }
}
