<?php

declare(strict_types=1);

namespace Profesia\CorrelationId\Test\Integration\Storage;

use PHPUnit\Framework\TestCase;
use Profesia\CorrelationId\Storage\CorrelationIdPutenvStorage;

class CorrelationIdPutenvStorageTest extends TestCase
{
    public function testCanStoreVariableIntoEnv(): void
    {
        $storage = new CorrelationIdPutenvStorage();
        $key     = 'key';
        $value   = 'value';
        \putenv("$key");

        $this->assertEquals(false, \getenv($key));
        $this->assertEquals(null, $storage->read($key));
        $storage->store('key', $value);

        $this->assertEquals($value, \getenv($key));
    }

    public function testCanReadValue(): void
    {
        $storage = new CorrelationIdPutenvStorage();
        $key     = 'key';
        $value   = 'value';

        \putenv("$key");
        $this->assertEquals(false, \getenv($key));
        $this->assertEquals(null, $storage->read($key));
        $storage->store('key', 'value');

        $this->assertEquals($value, $storage->read($key));
    }
}
