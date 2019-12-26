<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;
use WJS\API\GraphQL\Schema\Type;

class GroupFilterInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => "GroupFilterInput",
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
