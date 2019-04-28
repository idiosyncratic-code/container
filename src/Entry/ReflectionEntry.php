<?php

declare(strict_types=1);

namespace Idiosyncratic\Container\Entry;

use Closure;
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

    private $resolver;

    public function __construct(string $id, string $class)
    {
        $this->id = $id;

        $this->resolver = function (ContainerInterface $container) use ($class) {
            return $this->reflect($class, $container);
        };
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
        return ($this->resolver)($container);
    }

    public function extend(Closure $extension) : void
    {
        $previous = $this->resolver;

        $this->resolver = function (ContainerInterface $container) use ($extension, $previous) {
            return $extension($container, $previous($container));
        };
    }

    private function reflect(string $class, ContainerInterface $container)
    {
        $reflection = new ReflectionClass($class);

        if ($reflection->isInstantiable() === false) {
            throw new RuntimeException(sprintf('Could not create instance of %s', $class));
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
                    sprintf('Could not create instance of %s', $class)
                );
            }
        }

        return $reflection->newInstance(...$arguments);
    }
}
