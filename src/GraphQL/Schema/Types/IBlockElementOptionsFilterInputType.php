<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;
use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class IBlockElementOptionsFilterInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => "IBlockElementOptionsFilterInputType",
            'fields' => function () {
                return [
                    "fetch_files" => [
                        "type" => Type::nonNull(Type::boolean()),
                        "defaultValue" => false,
                    ],
                ];
            },
        ]);
    }
}
