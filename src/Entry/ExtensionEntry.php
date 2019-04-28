<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Closure;
use Psr\Container\ContainerInterface;

final class ExtensionEntry implements Entry
{
    /** @var string */
    private $id;

    /** @var callable */
    private $callable;

    private $entry;

    public function __construct(callable $extension, Entry $entry)
    {
        $this->id = $id;

        $this->entry = $entry;

        $extension = $extension instanceof Closure ? $extension : Closure::fromCallable($extension);

        $this->callable = function (ContainerInterface $container) use ($extension, $entry) {
            return $extension($container, $entry->resolve($container));
        };
    }

    /**
     * @inheritdoc
     */
    public function getId() : string
    {
        return $this->entry->getId();
    }

    /**
     * @inheritdoc
     */
    public function resolve(ContainerInterface $container)
    {
        return ($this->callable)($container);
    }
}
