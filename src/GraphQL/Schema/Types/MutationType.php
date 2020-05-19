<?php

namespace WJS\API\GraphQL\Schema\Types;

use WJS\API\Entities\SubscriberTable;
use WJS\API\GraphQL\Schema\Type;

/**
 * @package WJS\API\GraphQL\Schema\Types
 */
class MutationType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "inspectEventsSubscribe" => [
                    "type" => Type::string(),
                    "args" => [
                        [
                            "name" => "clientId",
                            "type" => Type::nonNull(Type::string()),
                        ],
                        [
                            "name" => "events",
                            "type" => Type::nonNull(Type::getInstance(ModuleEventSetInput::class)),
                        ],
                    ],
                    "resolve" => function (array $data, array $args = [], ?array $context = null): string {
                        // Актуализируем запись конкретного клиента
                        if ($clientRow = SubscriberTable::getByPrimary($args["clientId"])->fetch()) {
                            $result = SubscriberTable::update($clientRow["UUID"], [
                                "EVENTS" => $args["events"],
                                "UPDATED_AT" => time(),
                            ]);
                        } else {
                            $result = SubscriberTable::add([
                                "UUID" => $args["clientId"],
                                "EVENTS" => $args["events"],
                            ]);
                        }

                        if (!$result->isSuccess()) {
                            throw new \Error(join("\n", $result->getErrorMessages()));
                        }

                        return "OK";
                    }
                ],
                "inspectEventsUnsubscribe" => [
                    "type" => Type::string(),
                    "args" => [
                        [
                            "name" => "clientId",
                            "type" => Type::nonNull(Type::string()),
                        ],
                    ],
                    "resolve" => function (array $data, array $args = [], ?array $context = null): string {
                        // Актуализируем запись конкретного клиента
                        if ($clientRow = SubscriberTable::getByPrimary($args["clientId"])->fetch()) {
                            SubscriberTable::delete($clientRow["UUID"]);
                        }

                        return "OK";
                    }
                ],
            ];
        };
    }
}
