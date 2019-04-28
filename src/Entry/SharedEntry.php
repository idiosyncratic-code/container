<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Closure;
use Psr\Container\ContainerInterface;

final class SharedEntry implements Entry
{
    /** @var Entry */
    private $entry;

    /** @var mixed */
    private $resolved;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
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
        return $this->resolved ?? $this->resolved = $this->entry->resolve($container);
    }

    public function extend(Closure $extension) : void
    {
        $this->entry->extend($extension);

        $this->resolved = null;
    }
}
