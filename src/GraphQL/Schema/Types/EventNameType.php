<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;

class EventNameType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "module" => [
                    "type" => Type::string(),
                    "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                        return [];
                    }
                ],
            ];
        };
    }
}
