<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Closure;
use Psr\Container\ContainerInterface;

final class CallableEntry implements Entry
{
    /** @var string */
    private $id;

    /** @var callable */
    private $callable;

    public function __construct(string $id, callable $callable)
    {
        $this->id = $id;

        $this->callable = $callable instanceof Closure ? $callable : Closure::fromCallable($callable);
    }

    /**
     * @inheritdoc
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function resolve(ContainerInterface $container)
    {
        $callable = $this->callable;

        return $callable($container);
    }
}
