<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;
use WJS\API\GraphQL\Schema\Type;

class ModuleEventSetTypeInput extends InputObjectType
{
    const MODULE_MAIN = "main";
    const MODULE_IBLOCK = "iblock";

    public function __construct()
    {
        parent::__construct([
            "name" => "ModuleEventSetTypeInput",
            "fields" => function () {
                return [
                    static::MODULE_MAIN => [
                        "type" => Type::listOf(Type::nonNull(Type::getInstance(ModuleMainEventsType::class))),
                        "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                            return [];
                        }
                    ],
                    static::MODULE_IBLOCK => [
                        "type" => Type::listOf(Type::nonNull(Type::getInstance(ModuleIBlockEventsType::class))),
                        "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                            return [];
                        }
                    ],
                ];
            },
        ]);
    }
}
