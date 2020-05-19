<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;
use WJS\API\Resolvers\IBlock\Elements\Query as IBlockElementQuery;

class IBlockType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "elements" => [
                    'type' => Type::listOf(Type::nonNull(Type::getInstance(IBlockElementType::class))),
                    "args" => [
                        [
                            "name" => "order",
                            "type" => Type::nonNull(Type::listOf(
                                Type::nonNull(Type::getInstance(KeyValuePairInputType::class))
                            )),
                            "defaultValue" => [],
                        ],
                        [
                            "name" => "filter",
                            "type" => Type::nonNull(Type::listOf(
                                Type::nonNull(Type::getInstance(KeyValuePairInputType::class))
                            )),
                            "defaultValue" => [],
                        ],
                        // Опции группировки не поддерживаются (пока?)
                        [
                            "name" => "page",
                            "type" => Type::getInstance(IBlockElementPageFilterInputType::class),
                            "defaultValue" => null,
                        ],
                        [
                            "name" => "select",
                            "type" => Type::nonNull(Type::listOf(
                                Type::nonNull(Type::getInstance(KeyValuePairInputType::class))
                            )),
                            "defaultValue" => [],
                        ],
                        [
                            "name" => "options",
                            "type" => Type::getInstance(IBlockElementOptionsFilterInputType::class),
                            "defaultValue" => [],
                        ],
                    ],
                    'resolve' => function (array $data, array $args = [], ?array $context = null) {
                        return IBlockElementQuery::getList($args);
                    },
                ],
            ];
        };
    }
}
