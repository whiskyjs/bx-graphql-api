<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

class ModuleMainEventsType extends EnumType
{
    const EVENT_ON_PAGE_START = "OnPageStart";

    public function __construct()
    {
        parent::__construct([
            'name' => "ModuleMainEventsType",
            'description' => "Поддерживаемые события главного модуля.",
            'values' => [
                static::EVENT_ON_PAGE_START => [
                    'value' => self::EVENT_ON_PAGE_START,
                    'description' => 'OnPageStart',
                ],
            ]
        ]);
    }
}
