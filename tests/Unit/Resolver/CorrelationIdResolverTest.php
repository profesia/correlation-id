<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Unit\Resolver;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery;
use Profesia\CorrelationId\Generator\CorrelationIdGeneratorInterface;
use Profesia\CorrelationId\Resolver\CorrelationIdResolver;
use Profesia\CorrelationId\Storage\CorrelationIdStorageInterface;

class CorrelationIdResolverTest extends MockeryTestCase
{
    public function testCanResolve(): void
    {
        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);

        /** @var MockInterface|CorrelationIdStorageInterface $storage */
        $storage = Mockery::mock(CorrelationIdStorageInterface::class);

        $key      = 'key';
        $resolver = new CorrelationIdResolver(
            $generator,
            $storage,
            $key
        );

        $correlationId = $resolver->resolve();
        $this->assertEquals($key, $correlationId);

        $uuid = '7e8e94e2-bf74-4a52-a6de-5d33a8bd0836';
        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);
        $generator
            ->shouldReceive('generate')
            ->once()
            ->andReturn($uuid);

        $key      = '';
        $resolver = new CorrelationIdResolver(
            $generator,
            $storage,
            $key
        );

        $correlationId = $resolver->resolve();
        $this->assertEquals($uuid, $correlationId);

        $sameCorrelationId = $resolver->resolve();
        $this->assertEquals($uuid, $sameCorrelationId);
    }

    public function testCanOverrideReturningOfAlreadyGenerated(): void
    {
        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);
        $generator
            ->shouldReceive('generate')
            ->times(2)
            ->andReturn(
                'value1',
                'value2'
            );

        /** @var MockInterface|CorrelationIdStorageInterface $storage */
        $storage = Mockery::mock(CorrelationIdStorageInterface::class);

        $resolver = new CorrelationIdResolver(
            $generator,
            $storage,
            '',
            true
        );

        $this->assertEquals('value1', $resolver->resolve());
        $this->assertEquals('value2', $resolver->resolve());
    }

    public function testCanStore(): void
    {
        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);

        $key = 'storageKey';

        /** @var MockInterface|CorrelationIdStorageInterface $storage */
        $storage = Mockery::mock(CorrelationIdStorageInterface::class);
        $storage
            ->shouldReceive('store')
            ->once()
            ->withArgs(
                [
                    $key,
                    $key,
                ]
            );

        $resolver = new CorrelationIdResolver(
            $generator,
            $storage,
            $key,
        );

        $resolver->store();
    }
}
