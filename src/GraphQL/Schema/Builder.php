<?php

namespace WJS\API\GraphQL\Schema;

use Machaon\Std\Base\Singleton;
use WJS\API\Contracts\GraphQL\Field;
use WJS\API\GraphQL\Exceptions\SchemaException;
use WJS\API\GraphQL\Schema\Types\ExtensibleObjectType;

class Builder extends Singleton
{
    /**
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * @var array
     */
    protected $fieldsByParent = [];

    /**
     * @throws \Exception
     */
    protected function __construct()
    {
        $this->logger = logger(static::class);
    }

    /**
     * @param string $class
     * @throws SchemaException
     */
    public function registerField(string $class): void
    {
        if (!class_exists($class)) {
            throw new SchemaException('Class "{class}" not found or could not be loaded.', [
                "class" => $class,
            ]);
        }

        if (!in_array(Field::class, class_implements($class))) {
            throw new SchemaException('Invalid class: "{class}" does not implement Field and cannot be used.', [
                "class" => $class,
            ]);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $parent = $class::getParentClass();

        if (!in_array(ExtensibleObjectType::class, class_parents($parent))) {
            throw new SchemaException(
                'Invalid parent: class "{parent}" does not inherit from ExtensibleObjectType and cannot be extended.',
                [
                    "parent" => $parent,
                ]
            );
        }

        if (!isset($this->fieldsByParent[$parent])) {
            $this->fieldsByParent[$parent] = [];
        }

        if (in_array($class, $this->fieldsByParent[$parent])) {
            throw new SchemaException(
                'Field "{class}" has already been registered.',
                [
                    "class" => $class,
                ]
            );
        }

        $this->fieldsByParent[$parent][] = $class;
    }

    /**
     * @param array $classes
     * @throws SchemaException
     */
    public function registerFields(array $classes): void
    {
        foreach ($classes as $class) {
            $this->registerField($class);
        }
    }

    /**
     * @return array
     */
    public function getSchema(): array
    {
        $this->reattachFields();

        return [
            "query" => Type::query(),
            "mutation" => Type::mutation(),
        ];
    }

    protected function reattachFields(): void
    {
        foreach ($this->fieldsByParent as $parent => $classes) {
            /** @noinspection PhpUndefinedMethodInspection */
            $parent::clearFields();

            foreach ($classes as $class) {
                try {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $parent::registerField($class::getName(), [
                        'type' => $class::getType(),
                        'args' => $class::getArgs(),
                        'resolve' => function (...$args) use ($class) {
                            return $class::getInstance()->resolve(...$args);
                        },
                    ]);
                } catch (\Throwable $e) {
                    $this->logger->error($e->getMessage());
                }
            }
        }
    }
}
