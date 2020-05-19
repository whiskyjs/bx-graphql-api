<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\InputObjectType;

use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class ModuleEventSetInput extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            "name" => "ModuleEventSetInput",
            "fields" => function () {
                return [
                    EventInspectorModulesType::MAIN => [
                        "type" => Type::listOf(Type::nonNull(Type::getInstance(ModuleMainEventsType::class))),
                        "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                            return [];
                        }
                    ],
                    EventInspectorModulesType::IBLOCK => [
                        "type" => Type::listOf(Type::nonNull(Type::getInstance(ModuleIBlockEventsType::class))),
                        "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                            return [];
                        }
                    ],
                    EventInspectorModulesType::FORM => [
                        "type" => Type::listOf(Type::nonNull(Type::getInstance(ModuleFormEventsType::class))),
                        "resolve" => function (array $data, array $args = [], ?array $context = null): array {
                            return [];
                        }
                    ],
                ];
            },
        ]);
    }
}
