<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;
use WJS\API\Resolvers\Group\Query as GroupQuery;
use WJS\API\Resolvers\User\Query as UserQuery;

class QueryType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "user" => [
                    "type" => Type::getInstance(UserType::class),
                    "args" => [
                        [
                            "name" => "by",
                            "type" => Type::string(),
                            "defaultValue" => "ID",
                        ],
                        [
                            "name" => "order",
                            "type" => Type::string(),
                            "defaultValue" => "ASC",
                        ],
                        [
                            "name" => "filter",
                            "type" => Type::getInstance(UserFilterInputType::class),
                            "defaultValue" => [],
                        ],

                    ],
                    "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                        return first_of(UserQuery::get(
                            $args["by"],
                            $args["order"],
                            $args["filter"]
                        ));
                    }
                ],
                "group" => [
                    "type" => Type::getInstance(GroupType::class),
                    "args" => [
                        [
                            "name" => "by",
                            "type" => Type::string(),
                            "defaultValue" => "ID",
                        ],
                        [
                            "name" => "order",
                            "type" => Type::string(),
                            "defaultValue" => "ASC",
                        ],
                        [
                            "name" => "filter",
                            "type" => Type::getInstance(GroupFilterInputType::class),
                            "defaultValue" => [],
                        ],

                    ],
                    "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                        return first_of(GroupQuery::get(
                            $args["by"],
                            $args["order"],
                            $args["filter"]
                        ));
                    }
                ],
                "inspect" => [
                    "type" => Type::getInstance(InspectType::class),
                    "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                        return [];
                    }
                ]
            ];
        };
    }
}
