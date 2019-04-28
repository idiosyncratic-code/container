<?php

declare(strict_types=1);

namespace Idiosyncratic\Container;

use Idiosyncratic\Container\Entry\Entry;
use Idiosyncratic\Container\Entry\EntryFactory;
use Idiosyncratic\Container\Entry\ExtendableEntry;
use Idiosyncratic\Container\Entry\ExtensionEntry;
use Idiosyncratic\Container\Entry\SharedEntry;
use Idiosyncratic\Container\Exception\CouldNotFindEntry;
use Idiosyncratic\Container\Exception\CouldNotResolveEntry;
use Psr\Container\ContainerInterface;
use Throwable;

final class Container implements ContainerInterface
{
    /** @var array<string, Entry> */
    private $entries;

    /** @var EntryFactory */
    private $entryFactory;

    public function __construct()
    {
        $this->entryFactory = new EntryFactory();
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            throw new CouldNotFindEntry($id);
        }

        try {
            return $this->entries[$id]->resolve($this);
        } catch (Throwable $throwable) {
            throw new CouldNotResolveEntry($id, $throwable);
        }
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        return isset($this->entries[$id]);
    }

    /**
     * @param mixed $entry
     */
    public function add(string $id, $entry) : void
    {
        $this->entries[$id] = $this->entryFactory->create($id, $entry);
    }

    /**
     * @param mixed $entry
     */
    public function share(string $id, $entry) : void
    {
        $this->entries[$id] = new SharedEntry($this->entryFactory->create($id, $entry));
    }

    public function extend(string $id, callable $extension) : void
    {
        if ($this->has($id) === false) {
            throw new CouldNotFindEntry($id);
        }

        if ($this->entries[$id] instanceof ExtendableEntry) {
            $this->entries[$id]->extend($extension);
        } else {
            $this->entries[$id] = new ExtensionEntry($extension, $this->entries[$id]);
        }
    }
}
