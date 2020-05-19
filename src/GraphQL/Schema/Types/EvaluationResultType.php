<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class EvaluationResultType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return [
            "output" => [
                'type' => Type::nonNull(Type::string()),
            ],
            "result" => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }
}
