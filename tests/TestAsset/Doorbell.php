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

    public function changeTone(ToneInterface $tone)
    {
        $this->tone = $tone;
    }

    public function ring() : string
    {
        return $this->tone->tone();
    }
}
