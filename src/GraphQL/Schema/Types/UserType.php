<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;
use WJS\API\Resolvers\Group\Query as GroupQuery;

class UserType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "ID" => [
                    'type' => Type::nonNull(Type::id()),
                ],
                "LOGIN" => [
                    'type' => Type::nonNull(Type::string()),
                ],
                "EMAIL" => [
                    'type' => Type::nonNull(Type::string()),
                ],
                "GROUPS" => [
                    'type' => Type::listOf(Type::getInstance(GroupType::class)),
                    'resolve' => function (array $data, array $args = [], ?array $context = null) {
                        return GroupQuery::get("ID", "ASC", [
                            "ID" => join("|", GroupQuery::getUserGroupIds($data["ID"]))
                        ]);
                    },
                ],
            ];
        };
    }
}
