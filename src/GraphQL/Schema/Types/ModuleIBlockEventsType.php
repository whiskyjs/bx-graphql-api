<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

class ModuleIBlockEventsType extends EnumType
{
    const EVENT_BEFORE_ELEMENT_UPDATE = "OnBeforeIBlockElementUpdate";

    public function __construct()
    {
        parent::__construct([
            'name' => "ModuleIBlockEventsType",
            'description' => "Поддерживаемые события модуля 'iblock'.",
            'values' => [
                static::EVENT_BEFORE_ELEMENT_UPDATE => [
                    'value' => self::EVENT_BEFORE_ELEMENT_UPDATE,
                    'description' => self::EVENT_BEFORE_ELEMENT_UPDATE,
                ],
            ]
        ]);
    }
}
