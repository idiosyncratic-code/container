<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Exception;

use OutOfBoundsException;
use Psr\Container\NotFoundExceptionInterface;
use function sprintf;

final class CouldNotFindEntry extends OutOfBoundsException implements NotFoundExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf("Could not find entry '%s'", $id));
    }
}
