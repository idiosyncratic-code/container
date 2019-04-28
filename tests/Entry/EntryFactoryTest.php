<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class EntryFactoryTest extends TestCase
{
    public function testItCreatesBaseEntries() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $factory = new EntryFactory();

        $entry = $factory->create('test', ['foo', 'bar']);

        $this->assertEquals(['foo', 'bar'], $entry->resolve($container));

        $this->assertInstanceOf(BaseEntry::class, $entry);

        $entry = $factory->create('test', 'foo');

        $this->assertInstanceOf(BaseEntry::class, $entry);

        $this->assertEquals('foo', $entry->resolve($container));
    }
}
