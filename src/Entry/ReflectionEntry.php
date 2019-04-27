<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use RuntimeException;
use Throwable;
use function sprintf;

final class ReflectionEntry implements Entry
{
    /** @var string */
    private $id;

    /** @var string */
    private $class;

    public function __construct(string $id, string $class)
    {
        $this->id = $id;

        $this->class = $class;
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
        $reflection = new ReflectionClass($this->class);

        if ($reflection->isInstantiable() === false) {
            throw new RuntimeException(sprintf('Could not create instance of %s', $this->class));
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return $reflection->newInstance();
        }

        $arguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            try {
                $type = $parameter->getClass();

                if ($type === null) {
                    throw new Exception('Parameter type is not a valid class');
                }

                $arguments[] = $container->get($type->getName());
            } catch (Throwable $throwable) {
                throw new RuntimeException(
                    sprintf('Could not create instance of %s', $this->class)
                );
            }
        }

        return $reflection->newInstance(...$arguments);
    }
}
