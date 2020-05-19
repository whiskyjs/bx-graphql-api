<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;
use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class IBlockElementPageFilterInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => "IBlockElementPageFilterInputType",
            'fields' => function () {
                return [
                    "index" => [
                        "type" => Type::int(),
                    ],
                    "size" => [
                        "type" => Type::int(),
                    ],
                    "limit" => [
                        "type" => Type::int(),
                    ],
                ];
            },
        ]);
    }
}
