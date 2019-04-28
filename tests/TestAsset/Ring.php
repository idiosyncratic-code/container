<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\TestAsset;

class Ring implements ToneInterface
{
    public function tone() : string
    {
        return "ring!";
    }
}
