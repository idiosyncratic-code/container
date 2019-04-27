<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Idiosyncratic\Container\Container;
use Idiosyncratic\Container\TestAsset\Buzz;
use Idiosyncratic\Container\TestAsset\Doorbell;
use Idiosyncratic\Container\TestAsset\Greeter;
use Idiosyncratic\Container\TestAsset\ToneInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use RuntimeException;

class ReflectionEntryTest extends TestCase
{
    public function testItReflectsClassesWithNoConstructorParameters() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $entry = new ReflectionEntry(ToneInterface::class, Buzz::class);

        $this->assertEquals(ToneInterface::class, $entry->getId());

        $this->assertInstanceOf(Buzz::class, $entry->resolve($container));
    }

    public function testItReflectsClassesWithConstructorParameter() : void
    {
        $container = new Container();

        $container->add(ToneInterface::class, Buzz::class);

        $entry = new ReflectionEntry(Doorbell::class, Doorbell::class);

        $this->assertInstanceOf(Doorbell::class, $entry->resolve($container));
    }

    public function testItFailsToReflectClassesWithNonObjectConstructorParameter() : void
    {
        $this->expectException(RuntimeException::class);

        $container = $this->createMock(ContainerInterface::class);

        $entry = new ReflectionEntry(Greeter::class, Greeter::class);

        $entry->resolve($container);
    }

    public function testItFailsToReflectInterfaces() : void
    {
        $this->expectException(RuntimeException::class);

        $container = $this->createMock(ContainerInterface::class);

        $entry = new ReflectionEntry(ToneInterface::class, ToneInterface::class);

        $entry->resolve($container);
    }
}
