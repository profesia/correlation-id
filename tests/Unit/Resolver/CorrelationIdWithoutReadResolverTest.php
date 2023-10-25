<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Unit\Resolver;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Profesia\CorrelationId\Generator\CorrelationIdGeneratorInterface;
use Profesia\CorrelationId\Resolver\CorrelationIdResolver;
use Profesia\CorrelationId\Resolver\CorrelationIdWithoutReadResolver;
use Profesia\CorrelationId\Storage\CorrelationIdStorageInterface;

class CorrelationIdWithoutReadResolverTest extends MockeryTestCase
{
    public function testCanResolve(): void
    {
        $key = 'empty-string';

        /** @var MockInterface|CorrelationIdStorageInterface $storage */
        $storage = Mockery::mock(CorrelationIdStorageInterface::class);

        $uuid = '7e8e94e2-bf74-4a52-a6de-5d33a8bd0836';
        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);
        $generator
            ->shouldReceive('generate')
            ->once()
            ->andReturn($uuid);

        $resolver = new CorrelationIdWithoutReadResolver(
            $generator,
            $storage,
            $key
        );

        $correlationId = $resolver->resolve();
        $this->assertEquals($uuid, $correlationId);
    }

    public function testCanStoreInputParam(): void
    {
        $inputValue = 'test-value';

        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);
        $generator
            ->shouldNotReceive('generate');

        $key = 'testing';

        /** @var MockInterface|CorrelationIdStorageInterface $storage */
        $storage = Mockery::mock(CorrelationIdStorageInterface::class);
        $storage
            ->shouldReceive('store')
            ->once()
            ->withArgs(
                [
                    $key,
                    $inputValue,
                ]
            );
        $storage
            ->shouldNotReceive('read');

        $resolver = new CorrelationIdWithoutReadResolver(
            $generator,
            $storage,
            $key,
        );

        $resolver->store(
            $inputValue
        );
    }

    public function testCanResolveFromEnvAndStore(): void
    {
        $key = 'key';

        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);
        $generator
            ->shouldReceive('generate')
            ->once()
            ->andReturn(
                $key
            );

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
        $storage
            ->shouldNotReceive('read');

        $resolver = new CorrelationIdWithoutReadResolver(
            $generator,
            $storage,
            $key,
        );

        $resolver->store();
    }
}