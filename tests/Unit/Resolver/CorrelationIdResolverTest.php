<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Unit\Resolver;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery;
use Profesia\CorrelationId\Generator\CorrelationIdGeneratorInterface;
use Profesia\CorrelationId\Resolver\CorrelationIdResolver;

class CorrelationIdResolverTest extends MockeryTestCase
{
    public function testCanResolve(): void
    {
        /** @var MockInterface|CorrelationIdGeneratorInterface $generator */
        $generator = Mockery::mock(CorrelationIdGeneratorInterface::class);

        $key = 'key';
        $resolver = new CorrelationIdResolver(
            $generator,
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

        $key = '';
        $resolver = new CorrelationIdResolver(
            $generator,
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

        $resolver = new CorrelationIdResolver(
            $generator,
            '',
            true
        );

        $this->assertEquals('value1', $resolver->resolve());
        $this->assertEquals('value2', $resolver->resolve());
    }
}
