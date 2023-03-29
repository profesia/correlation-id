<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Resolver;

use Profesia\CorrelationId\Generator\CorrelationIdGeneratorInterface;
use Profesia\CorrelationId\Storage\CorrelationIdStorageInterface;

class CorrelationIdResolver implements CorrelationIdResolverInterface
{
    private CorrelationIdGeneratorInterface $generator;
    private CorrelationIdStorageInterface $storage;
    private string $correlationIdKey;

    public function __construct(
        CorrelationIdGeneratorInterface $generator,
        CorrelationIdStorageInterface $storage,
        string $correlationIdKey
    ) {
        $this->generator        = $generator;
        $this->storage          = $storage;
        $this->correlationIdKey = $correlationIdKey;
    }

    public function resolve(): string
    {
        $alreadyGeneratedCorrelationId = $this->storage->read($this->correlationIdKey);
        if ($alreadyGeneratedCorrelationId === null) {
            $alreadyGeneratedCorrelationId = $this->generator->generate();
        }

        return $alreadyGeneratedCorrelationId;
    }

    public function store(?string $value = null): void
    {
        if ($value === null) {
            $value = $this->resolve();
        }

        $this->storage->store($this->correlationIdKey, $value);
    }
}
