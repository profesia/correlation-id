<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Resolver;

use Profesia\CorrelationId\Generator\CorrelationIdGeneratorInterface;
use Profesia\CorrelationId\Storage\CorrelationIdStorageInterface;

class CorrelationIdResolver
{
    private ?string $generatedId;

    public function __construct(
        private CorrelationIdGeneratorInterface $generator,
        private CorrelationIdStorageInterface $storage,
        private string $correlationIdKey,
        private bool $alwaysCheckEnv = false,
    ) {
        $this->generatedId = null;
    }

    public function resolve(): string
    {
        if ($this->alwaysCheckEnv === false && $this->generatedId !== null) {
            return $this->generatedId;
        }

        $alreadyGeneratedCorrelationId = getenv($this->correlationIdKey);
        if ($alreadyGeneratedCorrelationId === '' || $alreadyGeneratedCorrelationId === false) {
            $alreadyGeneratedCorrelationId = $this->generator->generate();
        }

        $this->generatedId = $alreadyGeneratedCorrelationId;

        return $this->generatedId;
    }

    public function store(): void
    {
        $this->storage->store($this->correlationIdKey, $this->resolve());
    }
}
