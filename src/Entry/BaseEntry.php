<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Psr\Container\ContainerInterface;

final class BaseEntry implements Entry
{
    /** @var string */
    private $id;

    /** @var mixed */
    private $content;

    /**
     * @param mixed $content
     */
    public function __construct(string $id, $content)
    {
        $this->id = $id;

        $this->content = $content;
    }

    /**
     * @inheritdoc
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function resolve(ContainerInterface $container)
    {
        return $this->content;
    }
}
