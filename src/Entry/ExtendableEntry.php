<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Closure;
use Psr\Container\ContainerInterface;

interface ExtendableEntry extends Entry
{
    public function extend(callable $extension) : void;

    public function getId() : string;
}
