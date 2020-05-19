<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class ModuleMainEventsType extends EnumType
{
    const EVENT_ON_BEFORE_EVENT_ADD = "OnBeforeEventAdd";
    const EVENT_ON_BEFORE_EVENT_SEND = "OnBeforeEventSend";

    public function __construct()
    {
        parent::__construct([
            'name' => "ModuleMainEvents",
            'description' => "Поддерживаемые события главного модуля.",
            'values' => [
                static::EVENT_ON_BEFORE_EVENT_ADD => [
                    'value' => self::EVENT_ON_BEFORE_EVENT_ADD,
                    'description' => self::EVENT_ON_BEFORE_EVENT_ADD,
                    'args' => [
                        "event",
                        "siteId",
                        "arFields",
                        "templateId",
                        "files",
                        "languageId",
                    ],
                ],
                static::EVENT_ON_BEFORE_EVENT_SEND => [
                    'value' => self::EVENT_ON_BEFORE_EVENT_SEND,
                    'description' => self::EVENT_ON_BEFORE_EVENT_SEND,
                    'args' => [
                        "arFields",
                        "arTemplate",
                        "context",
                    ],
                ],
            ]
        ]);
    }
}
