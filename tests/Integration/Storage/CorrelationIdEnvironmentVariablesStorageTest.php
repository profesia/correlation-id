<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Integration\Storage;

use PHPUnit\Framework\TestCase;
use Profesia\CorrelationId\Storage\CorrelationIdEnvironmentStorage;

class CorrelationIdEnvironmentVariablesStorageTest extends TestCase
{
    public function testCanStoreVariableIntoEnv(): void
    {
        $storage = new CorrelationIdEnvironmentStorage();
        $key     = 'key';
        $value   = 'value';

        $this->assertEquals(false, getenv($key));
        $storage->store('key', $value);

        $this->assertEquals($value, getenv($key));
    }
}
