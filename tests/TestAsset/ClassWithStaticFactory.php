<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\TestAsset;

class ClassWithStaticFactory
{
    public static function create()
    {
        return new self();
    }
}
