<?php

namespace WJS\API\GraphQL\Schema;

use GraphQL\Type\Definition\Type as GenericType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\NullableType;

use WJS\API\GraphQL\Schema\Types\MutationType;
use WJS\API\GraphQL\Schema\Types\QueryType;

class Type
{
    /**
     * @var array
     */
    protected static $instances = [];

    /**
     * @param string $class
     * @return GenericType
     */
    public static function getInstance(string $class): GenericType
    {
        if (!static::$instances[$class]) {
            static::$instances[$class] = new $class;
        }

        return static::$instances[$class];
    }

    // Скалярные типы

    /**
     * @return ScalarType
     */
    public static function boolean(): ScalarType
    {
        return GenericType::boolean();
    }

    /**
     * @return ScalarType
     */
    public static function float(): ScalarType
    {
        return GenericType::float();
    }

    /**
     * @return ScalarType
     */
    public static function id(): ScalarType
    {
        return GenericType::id();
    }

    /**
     * @return ScalarType
     */
    public static function int(): ScalarType
    {
        return GenericType::int();
    }

    /**
     * @return ScalarType
     */
    public static function string(): ScalarType
    {
        return GenericType::string();
    }

    /**
     * @param GenericType $type
     * @return ListOfType
     */
    public static function listOf(GenericType $type): ListOfType
    {
        return new ListOfType($type);
    }

    /**
     * @param NullableType $type
     * @return NonNull
     */
    public static function nonNull(NullableType $type): NonNull
    {
        return new NonNull($type);
    }

    // Общие типы

    /**
     * @return QueryType
     */
    public static function query(): QueryType
    {
        return QueryType::getInstance();
    }

    /**
     * @return MutationType
     */
    public static function mutation(): MutationType
    {
        return MutationType::getInstance();
    }
}
