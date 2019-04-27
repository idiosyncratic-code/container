<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Exception;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;
use Throwable;
use function sprintf;

class CouldNotResolveEntry extends RuntimeException implements ContainerExceptionInterface
{
    public function __construct(string $id, Throwable $throwable)
    {
        parent::__construct(
            sprintf(
                "Could not resolve entry '%s'. Message: \"%s\"",
                $id,
                $throwable->getMessage()
            ),
            0,
            $throwable
        );
    }
}
