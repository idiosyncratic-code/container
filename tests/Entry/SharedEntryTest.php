<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Idiosyncratic\Container\TestAsset\ClassWithStaticFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;

class SharedEntryTest extends TestCase
{
    public function testItReturnsTheSameValue() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $callable = [ClassWithStaticFactory::class, 'create'];

        $entry = new SharedEntry(new CallableEntry('test', $callable));

        $this->assertEquals('test', $entry->getId());

        $this->assertSame($entry->resolve($container), $entry->resolve($container));
    }
}
