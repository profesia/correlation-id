<?php

declare(strict_types=1);

namespace Profesia\CorrelatioId\Test\Integration\Resolver;

use PHPUnit\Framework\TestCase;
use Profesia\CorrelationId\Test\Assets\NullCorrelationIdStorage;
use Profesia\CorrelationId\Resolver\CorrelationIdResolver;
use Profesia\CorrelationId\Test\Assets\TestUuidGenerator;

class CorrelationIdResolverTest extends TestCase
{
    public function testCanResolveIdFromEnvironmentParam(): void
    {
        $key      = 'key';
        $resolver = new CorrelationIdResolver(
            new TestUuidGenerator(),
            new NullCorrelationIdStorage(),
            $key
        );

        $resolvedId = $resolver->resolve();
        $this->assertEquals($key, $resolvedId);
    }

    public function testCanGenerateIdWhenEnvIdIsNotSet(): void
    {
        $key      = '';
        $resolver = new CorrelationIdResolver(
            new TestUuidGenerator(),
            new NullCorrelationIdStorage(),
            $key
        );

        $resolvedId = $resolver->resolve();
        $this->assertEquals(TestUuidGenerator::VALUE, $resolvedId);
    }

    public function testCanStoreGeneratedIdIntoServer(): void
    {
        $generator = new TestUuidGenerator();
        $resolver = new CorrelationIdResolver(
            $generator,
            new NullCorrelationIdStorage(),
            'test'
        );

        $this->assertEquals(null, getenv('test'));
        $resolver->store();
        $this->assertEquals('test', getenv('test'));
    }
}
