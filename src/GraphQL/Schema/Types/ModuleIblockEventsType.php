<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

class ModuleIblockEventsType extends EnumType
{
    const EVENT_BEFORE_ELEMENT_UPDATE = "OnBeforeIBlockElementUpdate";
    const EVENT_AFTER_ELEMENT_UPDATE = "OnAfterIBlockElementUpdate";

    public function __construct()
    {
        parent::__construct([
            'name' => "ModuleIblockEvents",
            'description' => "Поддерживаемые события модуля 'iblock'.",
            'values' => [
                static::EVENT_BEFORE_ELEMENT_UPDATE => [
                    'value' => self::EVENT_BEFORE_ELEMENT_UPDATE,
                    'description' => self::EVENT_BEFORE_ELEMENT_UPDATE,
                    'args' => [
                        'arParams',
                    ],
                ],static::EVENT_AFTER_ELEMENT_UPDATE => [
                    'value' => self::EVENT_AFTER_ELEMENT_UPDATE,
                    'description' => self::EVENT_AFTER_ELEMENT_UPDATE,
                    'args' => [
                        'arParams',
                    ],
                ],
            ]
        ]);
    }
}
