<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\TestAsset;

class Buzz implements ToneInterface
{
    public function tone() : string
    {
        return "buzzzzz!";
    }
}
