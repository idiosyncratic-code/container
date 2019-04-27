<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\TestAsset;

class Doorbell
{
    private $tone;

    public function __construct(ToneInterface $tone)
    {
        $this->tone = $tone;
    }

    public function ring() : void
    {
        print $this->tone->tone();
    }
}
