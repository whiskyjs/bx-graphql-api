<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;
use WJS\API\GraphQL\Schema\Type;

class UserFilterInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => "UserFilterInput",
            'fields' => function () {
                return [
                    "ID" => [
                        "type" => Type::id()
                    ],
                    "NAME" => [
                        "type" => Type::string()
                    ],
                ];
            },
        ]);
    }
}
