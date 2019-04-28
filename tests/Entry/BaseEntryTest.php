<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class BaseEntryTest extends TestCase
{
    public function testItReturnsContent() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $content = ['foo', 'bar'];

        $entry = new BaseEntry('test', $content);

        $this->assertEquals('test', $entry->getId());

        $this->assertEquals($content, $entry->resolve($container));
    }

    public function testItIsExtendable() : void
    {
        $container = $this->createMock(ContainerInterface::class);

        $content = ['foo', 'bar'];

        $expectedContent = ['foo', 'bar', 'baz'];

        $entry = new BaseEntry('test', $content);

        $entry->extend(function (ContainerInterface $container, $previous) {
            $previous[] = 'baz';

            return $previous;
        });

        $this->assertEquals($expectedContent, $entry->resolve($container));
    }
}
