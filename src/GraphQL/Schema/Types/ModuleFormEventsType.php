<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

class ModuleFormEventsType extends EnumType
{
    const EVENT_BEFORE_RESULT_ADD = "OnBeforeResultAdd";
    const EVENT_AFTER_RESULT_ADD = "OnAfterResultAdd";

    public function __construct()
    {
        parent::__construct([
            'name' => "ModuleFormEvents",
            'description' => "Поддерживаемые события модуля 'form'.",
            'values' => [
                static::EVENT_BEFORE_RESULT_ADD => [
                    'value' => self::EVENT_BEFORE_RESULT_ADD,
                    'description' => self::EVENT_BEFORE_RESULT_ADD,
                    'args' => [
                        'formId',
                        'arFields',
                        'arValues',
                    ],
                ],static::EVENT_AFTER_RESULT_ADD => [
                    'value' => self::EVENT_AFTER_RESULT_ADD,
                    'description' => self::EVENT_AFTER_RESULT_ADD,
                    'args' => [
                        'formId',
                        'resultId',
                    ],
                ],
            ]
        ]);
    }
}
