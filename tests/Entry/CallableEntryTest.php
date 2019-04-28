<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Idiosyncratic\Container\TestAsset\ClassWithStaticFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;

class CallableEntryTest extends TestCase
{
    public function testItResolvesClosures() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $callable = function () {
            return new stdClass();
        };

        $entry = new CallableEntry('test', $callable);

        $this->assertEquals('test', $entry->getId());

        $this->assertInstanceOf(stdClass::class, $entry->resolve($container));
    }

    public function testItResolvesArrayCallables() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $callable = [ClassWithStaticFactory::class, 'create'];

        $entry = new CallableEntry('test', $callable);

        $this->assertEquals('test', $entry->getId());

        $this->assertInstanceOf(ClassWithStaticFactory::class, $entry->resolve($container));

        $this->assertNotSame($entry->resolve($container), $entry->resolve($container));
    }

    public function testItIsExtendable() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $callable = function () {
            return new stdClass();
        };

        $entry = new CallableEntry('test', $callable);

        $entry->extend(function (ContainerInterface $container, $previous) {
            $previous->foo = 'baz';

            return $previous;
        });

        $resolved = $entry->resolve($container);

        $this->assertEquals('baz', $resolved->foo);
    }
}
