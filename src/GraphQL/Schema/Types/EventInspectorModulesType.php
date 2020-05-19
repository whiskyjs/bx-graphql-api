<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class EventInspectorModulesType extends EnumType
{
    const MAIN = "main";
    const IBLOCK = "iblock";
    const FORM = "form";

    /**
     * @return array
     */
    public static function getRawValues(): array
    {
        return [
            static::MAIN => static::MAIN,
            static::IBLOCK => static::IBLOCK,
            static::FORM => static::FORM,
        ];
    }

    public function __construct()
    {
        parent::__construct([
            'name' => "EventInspectorModules",
            'description' => "Поддерживаемые инспектором событий модули.",
            'values' => static::getRawValues(),
        ]);
    }
}
