<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use function class_exists;
use function interface_exists;
use function is_callable;
use function is_string;

class EntryFactory
{
    /**
     * @param mixed $content
     */
    public function create(string $id, $content) : Entry
    {
        if (is_callable($content)) {
            $entry = new CallableEntry($id, $content);
        } elseif ((class_exists($id) || interface_exists($id)) &&
            (is_string($content) && class_exists($content))
        ) {
            $entry = new ReflectionEntry($id, $content);
        } else {
            $entry = new BaseEntry($id, $content);
        }

        return $entry;
    }
}
