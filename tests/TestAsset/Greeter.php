<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\TestAsset;

class Greeter
{
    /** @var string */
    private $greeting;

    public function __construct(string $greeting)
    {
        $this->greeting = $greeting;
    }

    public function greet() : void
    {
        print $this->greeting;
    }
}
