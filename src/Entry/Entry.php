<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Psr\Container\ContainerInterface;

interface Entry
{
    /**
     * @return mixed
     */
    public function resolve(ContainerInterface $container);

    public function getId() : string;
}
