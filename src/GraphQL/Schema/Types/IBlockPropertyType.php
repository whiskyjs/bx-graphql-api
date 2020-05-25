<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class IBlockPropertyType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "ID" => [
                    "type" => Type::nonNull(Type::id()),
                ],
                "CODE" => [
                    "type" => Type::string(),
                ],
                "PROPERTY_TYPE" => [
                    "type" => Type::nonNull(Type::string()),
                ],
                "USER_TYPE" => [
                    "type" => Type::string(),
                ],
                "MULTIPLE" => [
                    "type" => Type::nonNull(Type::string()),
                ],
                "WITH_DESCRIPTION" => [
                    "type" => Type::nonNull(Type::string()),
                ],
                "VALUE" => [
                    "type" => Type::listOf(Type::string()),
                ],
                "DESCRIPTION" => [
                    "type" => Type::listOf(Type::string()),
                ],
                "VALUE_ENUM" => [
                    "type" => Type::listOf(Type::string()),
                ],
                "VALUE_XML_ID" => [
                    "type" => Type::listOf(Type::string()),
                ],
                "VALUE_SORT" => [
                    "type" => Type::listOf(Type::string()),
                ],
            ];
        };
    }
}
