<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class IBlockElementType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "fields" => [
                    'type' => Type::nonNull(Type::listOf(
                        Type::nonNull(Type::getInstance(IBlockFieldType::class))
                    )),
                    'resolve' => function (array $data, array $args = [], ?array $context = null) {
                        return $data["fields"];
                    },
                ],
                "properties" => [
                    'type' => Type::nonNull(Type::listOf(
                        Type::nonNull(Type::getInstance(IBlockPropertyType::class))
                    )),
                    'resolve' => function (array $data, array $args = [], ?array $context = null) {
                        return $data["properties"];
                    },
                ],
            ];
        };
    }
}
