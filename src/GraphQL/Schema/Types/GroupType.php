<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;
use WJS\API\Resolvers\User\Query as UserQuery;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class GroupType extends ExtensibleObjectType
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
                "NAME" => [
                    "type" => Type::string(),
                ],
                "USERS" => [
                    'type' => Type::listOf(Type::getInstance(UserType::class)),
                    'resolve' => function (array $data, array $args = [], ?array $context = null) {
                        return UserQuery::get("ID", "ASC", [
                            "GROUPS_ID" => [$data["ID"]],
                        ]);
                    },
                ],
            ];
        };
    }
}
