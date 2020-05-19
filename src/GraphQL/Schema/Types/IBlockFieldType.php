<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class IBlockFieldType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "CODE" => [
                    "type" => Type::nonNull(Type::string()),
                ],
                "VALUE" => [
                    "type" => Type::nonNull(Type::string()),
                ],
            ];
        };
    }
}
