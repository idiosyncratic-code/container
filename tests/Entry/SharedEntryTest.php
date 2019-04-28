<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Idiosyncratic\Container\Container;
use Idiosyncratic\Container\TestAsset\Buzz;
use Idiosyncratic\Container\TestAsset\ClassWithStaticFactory;
use Idiosyncratic\Container\TestAsset\Doorbell;
use Idiosyncratic\Container\TestAsset\Ring;
use Idiosyncratic\Container\TestAsset\ToneInterface;
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

    public function testItIsExtendable() : void
    {
        $container = new Container();

        $container->add(ToneInterface::class, function () {
            return new Buzz();
        });

        $entry = new SharedEntry(new ReflectionEntry(Doorbell::class, Doorbell::class));

        $entry->extend(function (ContainerInterface $container, Doorbell $previous) {
            $previous->changeTone(new Ring());

            return $previous;
        });

        $resolved = $entry->resolve($container);

        $this->assertEquals('ring!', $resolved->ring());

        $this->assertSame($resolved, $entry->resolve($container));
    }
}
