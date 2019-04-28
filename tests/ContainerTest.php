<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Idiosyncratic\Container\Container;
use Idiosyncratic\Container\Exception\CouldNotFindEntry;
use Idiosyncratic\Container\Exception\CouldNotResolveEntry;
use Idiosyncratic\Container\TestAsset\Buzz;
use Idiosyncratic\Container\TestAsset\Greeter;
use Idiosyncratic\Container\TestAsset\ToneInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ContainerTest extends TestCase
{
    public function testItCanNotResolveClassesWithNonObjectConstructorParameter() : void
    {
        $this->expectException(CouldNotResolveEntry::class);

        $container = new Container();

        $container->add(Greeter::class, Greeter::class);

        $container->get(Greeter::class);
    }

    public function testItCanNotFindUnregisteredEntries() : void
    {
        $this->expectException(CouldNotFindEntry::class);

        $container = new Container();

        $container->get('bad_entry');
    }

    public function testItCreatesSharedEntries() : void
    {
        $container = new Container();

        $container->share(ToneInterface::class, function () {
            return new Buzz();
        });

        $this->assertSame(
            $container->get(ToneInterface::class),
            $container->get(ToneInterface::class)
        );
    }
}
