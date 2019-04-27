<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Psr\Container\ContainerInterface;

class SharedEntry implements Entry
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
}
