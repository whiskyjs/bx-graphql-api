<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\ObjectType;

use WJS\API\GraphQL\Exceptions\SchemaException;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
abstract class ExtensibleObjectType extends ObjectType
{
    /**
     * @var array
     */
    protected static $fields = [];

    /**
     * @var array
     */
    protected static $instances = [];

    /**
     * @return static
     */
    public static function getInstance()
    {
        $className = get_called_class();

        if (!isset(static::$instances[$className])) {
            static::$instances[$className] = new static();
        }

        if (!isset(static::$fields[$className])) {
            static::$fields[$className] = [];
        }

        return static::$instances[$className];
    }

    /**
     * @param string $field
     * @param array $description
     * @throws SchemaException
     * @noinspection PhpUnused
     */
    public static function registerField(string $field, array $description)
    {
        $className = get_called_class();

        if (!isset(static::$fields[$className])) {
            static::$fields[$className] = [];
        }

        if (isset(static::$fields[$className][$field])) {
            throw new SchemaException('Field {field} already exists for type "{type}".', [
                "field" => $field,
                "type" => static::getName(),
            ]);
        }

        static::$fields[$className][$field] = $description;
    }

    /** @noinspection PhpUnused */
    public static function clearFields(): void
    {
        static::$fields[get_called_class()] = [];
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return preg_replace("#Type$#", "", str_replace(__NAMESPACE__ . '\\', '', get_called_class()));
    }

    /**
     * @param string $name
     * @param array|callable $fields
     */
    public function __construct(?string $name = null, $fields = [])
    {
        parent::__construct([
            'name' => $name ?: static::getName(),
            'fields' => function () use ($fields) {
                $defaultFields = static::getDefaultFields();

                return $fields ?: array_replace(
                    is_callable($defaultFields)
                        ? $defaultFields()
                        : $defaultFields,
                    static::$fields[get_called_class()] ?? []
                );
            }
        ]);
    }

    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return [];
    }

    final private function __clone()
    {
    }

    final private function __wakeup()
    {
    }
}
