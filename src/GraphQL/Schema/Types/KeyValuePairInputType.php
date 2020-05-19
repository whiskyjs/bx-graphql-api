<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;

use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class KeyValuePairInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => "KeyValuePairInputType",
            'fields' => function () {
                return [
                    "key" => [
                        "type" => Type::nonNull(Type::string()),
                    ],
                    "value" => [
                        "type" => Type::nonNull(Type::string()),
                    ],
                ];
            },
        ]);
    }
}
